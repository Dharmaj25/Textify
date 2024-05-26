<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TextAnalyzer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery.json-viewer@1.5.0/json-viewer/jquery.json-viewer.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>

<body>

    <!-- Header -->
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="./home.php">
                <img src="./assets/images/logo.png" class="ml-5" height="55px" width="55px" alt="">
                <p class="nav-brand">Textify</p>
            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
    </nav>
    <!-- Header -->

    <!-- Body -->
    <div class="columns">
        <div class="column is-half text-column">
            <p class="heading">Please <span style="color:#00d1b2">Enter Text</span> or <span
                    style="color:#00d1b2">Upload PDF</span> for Analysis</p>
            <form onsubmit="handleForm(event)">
                <div class="control">
                    <div style="display:flex">
                        <input type="radio" class="mr-2 " name="type-select" id="text-input-radio"
                            onclick="handleFileSelection(event)" checked />
                        <textarea class="textarea mt-2 is-primary" id="text-input"
                            placeholder="Enter text to analyze..." rows="8"></textarea>
                    </div>
                    <div class="file mt-5" id="file-input-wrapper">
                        <input class="mr-2" type="radio" name="type-select" id="file-input-radio"
                            onclick="handleFileSelection(event)" />
                        <label class="file-label">
                            <input class="file-input" type="file" name="file-text" accept=".pdf" id="file-input"
                                oninput="handlePdfInput(event)" disabled>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label"> Choose File...</span>
                            </span>
                            <span class="file-name" id="file-name" style="display:none"> </span>
                        </label>
                    </div>

                    <h1 class="subheading mb-4"> Choose the type of text analysis you want to perform
                    </h1>

                    <div class="buttons" style="margin-bottom:50px">
                        <button class="button is-danger" id="Named Entity Recognition" onclick="setOperation(event)"
                            type="button"> <i class="fa-solid fa-file-signature"></i>
                            &nbsp;Named
                            Entity
                            Recognition</button>
                        <button class="button is-success is-light" id="Sentiment Analysis" onclick="setOperation(event)"
                            type="button">
                            <i class="fa-solid fa-face-smile-wink"></i> &nbsp;Sentiment
                            Analysis</button>
                        <button class="button is-warning is-light" id="Relationship Identification"
                            onclick="setOperation(event)" type="button"> <i class="fa-solid fa-circle-nodes"></i>
                            &nbsp;Relationship
                            Identification</button>
                        <button class="button is-info is-light" id="Knowledge Graph" onclick="setOperation(event)"
                            type="button"><i class="fa-solid fa-chart-line"></i>&nbsp; Knowledge Graph</button>
                    </div>

                    <div class="submit-btn-wrapper" style="">
                        <button type="submit" id="submit-btn"
                            class="button is-primary is-medium is-fullwidth is-rounded"><i class="fa-solid fa-gear"></i>
                            &nbsp;Start
                            Analysis</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="column is-half text-column">
            <div>
                <h2 class="heading"> Analysis Results</h2>
                <pre id="result" class="json-viewer"></pre>
            </div>
        </div>
    </div>

    <!-- Body -->

    <script src="./js/home.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"
        integrity="sha512-ml/QKfG3+Yes6TwOzQb7aCNtJF4PUyha6R3w8pSTo/VJSywl7ZreYvvtUso7fKevpsI+pYVVwnu82YO0q3V6eg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.json-viewer@1.5.0/json-viewer/jquery.json-viewer.min.js"></script>
</body>

</html>