abs_path = "";
function setBlock(item) {
    $.ajax({
        type: "POST",
        url: abs_path + "controller.php",
        data: {
            action: "blocks",
            block_id: $(item).val()
        },
        dataType: 'JSON',
        success: function (result) {
           $("#lab").html("");
           var i = 0;
           $("#lab").append("<option>SELECCIONE</option>");
           while(i<result.length){
               $("#lab").append("<option value='"+result[i].id+"'>"+result[i].description+"</option>");
               i++;
           }
        }
    });
}

function getProductsByLab(item) {
    $.ajax({
        type: "POST",
        url: abs_path + "controller.php",
        data: {
            action: "productsByLab",
            lab_id: $(item).val()
        },
        dataType: 'JSON',
        success: function (result) {
           $("#producto").html("");
           var i = 0;
           $("#producto").append("<option>SELECCIONE</option>");
           while(i<result.length){
               $("#producto").append("<option value='"+result[i].id_product+"'>"+result[i].name+"</option>");
               i++;
           }
        }
    });
}