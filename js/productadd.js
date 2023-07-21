function add_product(){
    var sp=document.vaidation.selling_price.value;
    var cp=document.validation.cost_price.value;
    if(sp<cp){
        alert("selling price must be greater than cost price");
    }
    else if(sp<0){
        alert("selling price must be positive ");
    }
}