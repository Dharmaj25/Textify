## Dependencies
This project is set up on a XAMPP server for local development.

- [XAMPP](https://www.apachefriends.org/index.html): XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages.


## Setup Instructions
1. Clone the repository to your local machine.
2. Install XAMPP if not already installed.
3. Place the project folder in the `htdocs` directory of your XAMPP installation.
4. Start the Apache server and MySQL from the XAMPP control panel.
5. Open a web browser and navigate to `http://localhost/textify`.
6. Follow the on-screen instructions to use the text analysis functionality.


# Text Analysis Project
This project utilizes a set of APIs provided by RapidAPI and expert.ai for text analysis tasks.

## APIs Used
1. **Named Entity Recognition API**
   - [API Documentation](https://rapidapi.com/vbachani/api/namedentityrecognition)
   - Description: This API identifies and classifies entities in unstructured text.

2. **Sentiment Analysis API**
   - [API Documentation](https://rapidapi.com/raajreact/api/text-sentiment-analysis4)
   - Description: This API analyzes the sentiment of text and returns a sentiment score.

3. **Relationship Identification API**
   - [API Documentation](https://docs.expert.ai/nlapi/v2/guide/relation-extraction)
   - Description: This API identifies relationships between entities mentioned in the text.



## Usage
- Upon accessing the project URL, you will be presented with a form where you can enter text for analysis or upload a PDF file.
- Choose the type of analysis you want to perform from the available options: Named Entity Recognition, Sentiment Analysis, Relationship Identification, or Knowledge Graph.
- Click on the "Start Analysis" button to initiate the analysis process.
- View the analysis results on the same page.

## Contributors
- [Dharmaj Paniya](https://github.com/dharmaj25)
