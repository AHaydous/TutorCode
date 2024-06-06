var text = "\nif (interestedInCoding && wantToLearnCode) {\n   goToWebsite(\"https://TutorCode.com/coding\");\n   console.log(\"This is the perfect\n     website for you!\");\n}\n";
var textElement = document.getElementById("codeSnippet");
var i = 0;
var intervalId;

function animateCode() {
    intervalId = setInterval(function () {
        textElement.innerHTML += text.charAt(i);
        i++;
        if (i >= text.length) {
            clearInterval(intervalId);
            setTimeout(function () {
                i = 0;
                textElement.innerHTML = "";
                animateCode();
            }, 3000);
        }
    }, 100);
}

animateCode();