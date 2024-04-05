document.getElementById('check-duplication').addEventListener('click', async function(event) {
   
    document.getElementById("check-duplication").disabled = true;
    
    // Hide the text and show the spinner
    document.getElementById("check-text").style.display = "none";
    document.getElementById("check-spinner").style.display = "inline-block";
    document.getElementById("checking-text").style.display = "inline"; 
    const abstract = document.getElementById('abstract').value;
    const title = document.getElementById('title').value;
    const journalInfo = document.getElementById("journal-info")
    const response = await fetch('https://web-production-cecc.up.railway.app/api/check/journal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            abstract: abstract,
            title:title
        }),
    });
    
    const data = await response.json();
    
    if (response.ok) {
   
        const journalType = data.journal_classification;
        const dropdown = document.getElementById('journal-type');
        document.getElementById("check-duplication").disabled = false;
        document.getElementById("check-text").style.display = "inline";
        document.getElementById("check-spinner").style.display = "none";
        document.getElementById("checking-text").style.display = "none";
        journalInfo.innerHTML = "A match has been found. You may choose to follow this or select your preferred journal.";
        for (let i = 0; i < dropdown.options.length; i++) {
            if (dropdown.options[i].value === journalType) {
                dropdown.options[i].selected = true;
                break;
            }
        }
    } else {
        // Handle error here
        console.error('Error:', data.message);
        journalInfo.innerHTML = data.message;
        
    }


});



