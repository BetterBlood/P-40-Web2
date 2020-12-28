function addIngredient()
{
    var lastField = ++document.getElementById("numberOfIngredients").value;

    var htmlString = '<div class="form-row">';
    htmlString += '<input type="number" class="form-control col-md-2 mb-3 ml-auto mr-1 pt-n2 pb-n2" name="nbrIngredient' + lastField + '" placeholder="2" min="1" value="1">';
    htmlString += '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2" name="ingredient' + lastField + '" placeholder="L d\'eau">';
    htmlString += '</div>';

    document.getElementById("ingredients").innerHTML += htmlString;
}

function addStep()
{
    var lastField = ++document.getElementById("numberOfstep").value;

    var htmlString = '<div class="form-row">';
    htmlString += '<label class="mt-1" >' + lastField + ' -</label>';
    htmlString += '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2 ml-1" name="step' + lastField + '" placeholder="placer les cornichons coupés dans le fond d\'un plat">';
    htmlString += '</div>';

    document.getElementById("preparationStep").innerHTML += htmlString;
}

// function deleteLastStep()
// {
//     var lastField = document.getElementById("numberOfstep").value--;

//     //document.getElementById("preparationStep").removeChild("step" + lastField);

//     //document.getElementsByClassName("step" + lastField).parentNode.remo

//     var elements = document.getElementsByClassName("step" + lastField);
//     elements.remove();
//     while(elements.length > 0){
//         elements[0].remove(); //removeChild(elements[0]);
//     }
    
//     // element.parentNode.removeChild(element);
// }