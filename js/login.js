function login(){
    var username=document.validation.username.value;
    var password=document.validation.password.value;
    if(username==""){
        alert("please enter username");
    }
    if(password==""){
        alert("please enter password");
    }
}