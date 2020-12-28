function addIngredient()
{
    var totalfeilds = ++document.getElementById("numberOfIngredients").value;

    var htmlString = '<div class="form-row">';
    htmlString += '<input type="number" class="form-control col-md-2 mb-3 ml-auto mr-1 pt-n2 pb-n2" name="nbrIngredient' + totalfeilds + '" placeholder="2" min="1" value="1">';
    htmlString += '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2" name="ingredient' + totalfeilds + '" placeholder="L d\'eau">';
    htmlString += '</div>';

    document.getElementById("ingredients").innerHTML += htmlString;
}

function addStep()
{
    var totalfeilds = ++document.getElementById("numberOfstep").value;

    var htmlString = '<div class="form-row">';
    htmlString += '<label class="mt-1" >' + totalfeilds + ' -</label>';
    htmlString += '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2" name="step' + totalfeilds + '"placeholder="placer les cornichons coupés dans le fond d\'un plat">';
    htmlString += '</div>';

    document.getElementById("preparationStep").innerHTML += htmlString;
}