    $('.image').click(function(){
        // Create an auxiliary hidden input
        var aux = document.createElement("input");

        // Get the text from the element passed into the input
        aux.setAttribute("value", $(this).attr('src'));

        // Append the aux input to the body
        document.body.appendChild(aux);

        // Highlight the content
        aux.select();

        // Execute the copy command
        document.execCommand("copy");

        // Remove the input from the body
        document.body.removeChild(aux);
        alert($(this).attr('src'));
    });