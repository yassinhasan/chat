import  * as helper from "/chat/Public/js/helper.js";

//activate account 
let activateAcountBtn = document.querySelector(".activateAcount");
let activatemodal = new bootstrap.Modal(document.getElementById('activatemodal'));
let activateForm = document.querySelector(".activate-form");
let activateUrl = activateAcountBtn.getAttribute("data-target");
activateAcountBtn.addEventListener("click",()=>
{
    helper.showSpinners();
    let data = new FormData(activateForm);
    loadModel(activateUrl , data , activatemodal)
})

function loadModel(url,data,modal)
{
    helper.clearResultError();
    fetch(url,
        {
            method: "POST",
            body : data
        }).then(res=> res.json()).
        then(data=>{

          
            if(data.suc)
            {
                helper.hideSpinners();
                document.querySelector(".activate-warning").remove();
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 2000
                });
                modal.toggle();
                loadTable(data.results);
            }else if(data.err)
            {  
                helper.hideSpinners();
                for (const key in data.err) {
                    activateForm.querySelector(`.${key}`).style.display = "block";
                    activateForm.querySelector(` .${key}`).innerHTML = data.err[key];
                }
            }
            else if(data.failed)
            {  
                helper.hideSpinners();
                swal({
                    "text" : data.failed , 
                    "icon" : "warning",
                    "button" : false,
                    timer: 1500
                });
              
            }
        })

}

