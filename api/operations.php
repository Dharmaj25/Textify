<?php
$config = require '../config.php';
$rapid_api_key = $config['RAPID_API_KEY'];
$bearer_token = $config['BEARER_TOKEN'];

$text = $_POST["text"];
$type = $_POST["type"];
$url = "";
$headers = array();
$method = "POST";
$body = null;

switch ($type) {
    case "Named Entity Recognition":
        $url = "https://namedentityrecognition.p.rapidapi.com/ner";
        $headers = array(
            'Content-Type: application/json',
            "x-rapidapi-key: $rapid_api_key"
        );
        $body = json_encode(array('text' => $text));
        break;
    case "Sentiment Analysis":
        $method = "GET";
        $headers = array(
            'x-rapidapi-host: text-sentiment-analysis4.p.rapidapi.com',
            "x-rapidapi-key: $rapid_api_key"
        );
        $url = "https://text-sentiment-analysis4.p.rapidapi.com/sentiment?text=" . urlencode($text);
        break;
    case "Relationship Identification":
        $url = "https://nlapi.expert.ai/v2/analyze/standard/en/relations";
        $headers = array(
            "Authorization: Bearer $bearer_token",
            "Content-Type: application/json",
        );
        $body = json_encode(array('document' => array('text' => $text)));
        break;
    case "Knowledge Graph":
        generateKnowledgeGraph($text, $rapid_api_key, $bearer_token);
        break;
    default:
        echo json_encode(array("error" => "Invalid type specified."));
        exit;
}

if ($type !== "Knowledge Graph") {
    $response = callAPI($method, $url, $headers, $body, $type);
    echo json_encode($response);
}

function generateKnowledgeGraph($text, $rapid_api_key, $bearer_token)
{
    $nerHeaders = array(
        'Content-Type: application/json',
        "x-rapidapi-key: $rapid_api_key"
    );

    $relationsHeader = array(
        "Authorization: Bearer $bearer_token",
        "Content-Type: application/json",
    );

    $relationsBody = json_encode(array('document' => array('text' => $text)));

    $nerData = callAPI("POST", "https://namedentityrecognition.p.rapidapi.com/ner", $nerHeaders, json_encode(array('text' => $text)));
    $relationshipData = callAPI("POST", "https://nlapi.expert.ai/v2/analyze/standard/en/relations", $relationsHeader, $relationsBody);

    $ner = json_decode($nerData, true);
    $relationships = json_decode($relationshipData, true);

    $entities = [];
    if (isset($ner['entities'])) {
        foreach ($ner['entities'] as $entity) {
            $entityType = '';
            switch ($entity['label']) {
                case 'PERSON':
                    $entityType = 'Person';
                    break;
                case 'ORG':
                    $entityType = 'Organization';
                    break;
                case 'GPE':
                    $entityType = 'Place';
                    break;
                case 'DATE':
                    $entityType = 'Date';
                    break;
            }
            if ($entityType) {
                $entities[$entity['text']] = [
                    '@type' => $entityType,
                    'name' => $entity['text'],
                ];
            }
        }
    }

    $events = [];
    if (isset($relationships['data']['relations'])) {
        foreach ($relationships['data']['relations'] as $relationship) {
            $event = [
                '@type' => 'Event',
                'action' => $relationship['verb']['text'],
            ];
            foreach ($relationship['related'] as $related) {
                switch ($related['relation']) {
                    case 'when':
                        $event['date'] = date('Y-m-d', strtotime($related['text']));
                        break;
                    case 'where':
                        $event['location'] = $related['text'];
                        break;
                    case 'sbj_who':
                        $event['subject'] = $related['text'];
                        break;
                    case 'obj_what':
                        $event['object'] = $related['text'];
                        break;
                    case 'with_what':
                        $event['feedback'] = $related['text'];
                        break;
                }
            }
            $events[] = $event;
        }
    }

    $knowledgeGraph = array_merge(array_values($entities), $events);
    echo json_encode(json_encode($knowledgeGraph));
    exit;
}

function callAPI($method, $url, $headers, $body = null, $type = null)
{
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
        )
    );

    $result = curl_exec($curl);
    $decoded_result = json_decode($result, true);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return json_encode(
            array(
                "status" => "Error",
                "status_code" => 500,
                "message" => $err,
                "data" => array()
            )
        );
    }

    if ($type === "Relationship Identification")
        return json_encode($decoded_result['data']['relations']);
    else
        return $result;
}

