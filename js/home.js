let selectedOperation = "Named Entity Recognition";
let apiURL = "./api/ner.php";
let text = "";
let pdfText = "";
let buttonsArray = ["Named Entity Recognition", "Sentiment Analysis", "Relationship Identification", "Knowledge Graph"];

const handleForm = async (event) => {
    event.preventDefault();

    text = document.getElementById("text-input").value;
    if (text.length === 0 && pdfText.length === 0) {
        showToast("warning", "Please Enter Text or Upload a PDF File");
        return;
    }

    let submitBtn = document.getElementById("submit-btn");
    submitBtn.classList.add("is-loading");

    let formData = new FormData();

    if (pdfText.length > 0)
        formData.append("text", pdfText);
    else
        formData.append("text", text);
    formData.append("type", selectedOperation);

    let result = await callAPI(formData);
    console.log(result);
    $('#result').jsonViewer(JSON.parse(result));
    submitBtn.classList.remove("is-loading");
}


const setOperation = (event) => {
    selectedOperation = event.target.id;
    event.target.classList.remove("is-light");
    buttonsArray.forEach((btnID) => {
        if (event.target.id !== btnID)
            document.getElementById(btnID).classList.add("is-light");
    });
}

const callAPI = async (formData) => {
    try {
        let response = await fetch("./api/operations.php", {
            method: "POST",
            body: formData
        });
        let data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
    }
}

const handleFileSelection = (event) => {
    if (event.target.id === "text-input-radio") {
        document.getElementById("file-input").disabled = true;
        document.getElementById("text-input").disabled = false;
        document.getElementById('file-input-wrapper').classList.remove("is-primary")
    }
    else {
        document.getElementById("file-input").disabled = false;
        document.getElementById("text-input").disabled = true;
        document.getElementById('file-input-wrapper').classList.add("is-primary")
    }
}



const handlePdfInput = (event) => {
    let file = event.target.files[0];
    if (file != undefined && file.type == "application/pdf") {
        text = "";
        document.getElementById("text-input").value = "";
        let fileWrapper = document.getElementById("file-input-wrapper");
        let fileNameInput = document.getElementById("file-name");

        fileWrapper.classList.add("has-name");
        fileNameInput.style.display = "block";
        fileNameInput.innerText = file.name;

        let fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = () => {
            let res = fr.result;
            getPdfText(res);
        }
    } else {
        alert("Select a valid PDF file");
    }
}

const getPdfText = async (url) => {
    let alltext = [""];
    try {
        let pdf = await pdfjsLib.getDocument(url).promise
        let pages = pdf.numPages;
        for (let i = 1; i <= pages; i++) {
            let page = await pdf.getPage(i);
            let txt = await page.getTextContent();
            let text = txt.items.map((s) => s.str).join("");
            alltext[0] = alltext[0] + (text);
        }
        pdfText = alltext[0];
    } catch (err) {
        alert(err.message);
    }
}


const showToast = (type, message) => {
    Toastify({
        text: message,
        duration: 2000,
        gravity: "bottom",
        style: {
            background: type === "warning" ? "#00d1b2" : "",
        },
        close: true,

    }).showToast();
}
