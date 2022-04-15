// 
import  * as helper from "/chat/Public/js/helper.js";
//
let registerForm = document.querySelector(".register-form form");
let loginForm = document.querySelector(".login-form form");

let btn_login_swap = document.querySelector(".login-swap"),
        btn_register_swap = document.querySelector(".register-swap"),
		login_form = document.querySelector(".login-form"),
		register_form = document.querySelector(".register-form"),
		form_box = document.querySelector(".login-page .box");
		
btn_login_swap.addEventListener("click",()=>
            {
                btn_login_swap.classList.add("active");
                btn_register_swap.classList.remove("active");
                form_box.classList.remove("slide");
                login_form.classList.remove("hidden-form");
                register_form.classList.add("hidden-form");
})


btn_register_swap.addEventListener("click",()=>
            {
                registerForm.reset();
                btn_register_swap.classList.add("active");
                btn_login_swap.classList.remove("active");
                form_box.classList.add("slide");
                login_form.classList.add("hidden-form");
                register_form.classList.remove("hidden-form");
})




// add form
let btnLogin = document.querySelector(".login");
let saveurl = btnLogin.getAttribute("data-target");
btnLogin.addEventListener("click",(e)=>
{
    e.preventDefault();
    helper.showSpinners();
    let data = new FormData(loginForm);
    fetchLogin(saveurl , data )
})

function fetchLogin(url,data)
{
    fetch(url,
        {
            method: "POST",
            body : data
        }).then(res=>res.json()).
        then(data=>{
            helper.clearResultError();
            if(data.suc)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 1400
                });
               window.location.href = data.redir
            }
            else if(data.failed)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.failed , 
                    "icon" : "warning",
                    "button" : true,
                    "close" : true ,
                    timer: 2000
                });
            }
            else if(data.disabled)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.disabled , 
                    "icon" : "warning",
                    "button" : false,
                    timer: 1200
                });
            }
            else if(data.err)
            {  
                
                helper.hideSpinners();
                for (const key in data.err) {
                    loginForm.querySelector(`.${key}`).style.display = "block";
                    loginForm.querySelector(` .${key}`).innerHTML = data.err[key];
                }
            }
        });
}
// register 
let btnRegister = document.querySelector(".register");
let registerUrl = btnRegister.getAttribute("data-target");
btnRegister.addEventListener("click",(e)=>
{
    e.preventDefault();
    helper.showSpinners();
    let data = new FormData(registerForm);
    fetchRegister(registerUrl , data )
})

function fetchRegister(url,data)
{
    fetch(url,
        {
            method: "POST",
            body : data
        }).then(res=>res.json()).
        then(data=>{
            helper.clearResultError();
            if(data.suc)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 1800
                });
               window.location.href = data.redir
            }
            else if(data.failed)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.failed , 
                    "icon" : "warning",
                    "button" : true,
                    "close" : true ,
                    timer: 2000
                });
            }
            else if(data.disabled)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.disabled , 
                    "icon" : "warning",
                    "button" : false,
                    timer: 1400
                });
            }
            else if(data.err)
            {  
                helper.hideSpinners();
                for (const key in data.err) {
                    registerForm.querySelector(`.${key}`).style.display = "block";
                    registerForm.querySelector(` .${key}`).innerHTML = data.err[key];
                }
            }
        });
}

let allInputs = document.querySelectorAll(".form-group input");

allInputs.forEach(sInput=>
    {
        sInput.addEventListener("focus",()=>
        {
            let result = sInput.parentElement.querySelector(".results");
            result.style.display= "none";
            let Ilabel = sInput.parentElement.querySelector("label");
            if(Ilabel)
            {
                Ilabel.classList.add("focus")                
            }

        })
        sInput.addEventListener("keydown",()=>
        {
            let result = sInput.parentElement.querySelector(".results");
            result.style.display= "none";
            let Ilabel = sInput.parentElement.querySelector("label");
            if(Ilabel)
            {
                Ilabel.classList.add("focus")                
            }

        })
        sInput.addEventListener("keyup",()=>
        {
      
            let Ilabel = sInput.parentElement.querySelector("label");
            if(Ilabel)
            {
                if(sInput.value == "")
                {
                    Ilabel.classList.remove("focus")  
             
                }
            }

        })
        sInput.addEventListener("blur",()=>
        {
      
            let Ilabel = sInput.parentElement.querySelector("label");
            if(Ilabel)
            {

              Ilabel.classList.remove("focus")  
             
            }

        })
    })


















