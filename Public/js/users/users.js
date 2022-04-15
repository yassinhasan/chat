import  * as helper from "/chat/Public/js/helper.js";


let wraper = document.querySelector(".wraper");
// addmoda option ;
const option = {
    "backdrop" : 'static',
    "keyboard" : false
}
// addmoda  ;
let addModal = new bootstrap.Modal(document.getElementById('addmodal'), option);


// add form
let form = document.querySelector(".add-form");
// addbtn 
let addbtn = document.querySelector(".add-task .add");
addbtn.addEventListener("click",()=>
{

    form.reset()
    helper.clearResultError();
    addModal.toggle()
})

// save data 
let saventm  =  document.querySelector(".modal .save");
let saveurl = saventm.getAttribute("data-target");
saventm.addEventListener("click",()=>
{
    helper.showSpinners();
    let data = new FormData(form);
    loadModel(saveurl , data , addModal)
})

function loadModel(url,data,modal)
{
    fetch(url,
        {
            method: "POST",
            body : data
        }).then(res=> res.json()).
        then(data=>{
            helper.clearResultError();
          
            if(data.suc)
            {
                helper.hideSpinners();
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 1000
                });
                modal.toggle();
                loadTable(data.results);
            }else if(data.err)
            {  
                helper.hideSpinners();
                for (const key in data.err) {
                    document.querySelector(`.add-form .${key}`).style.display = "block";
                    document.querySelector(`.add-form .${key}`).innerHTML = data.err[key];
                }
            }
        });
}
// edit 
document.addEventListener("click",e=>
{
    if(e.target.classList.contains("edit"))
    {

        let  editbtn = e.target;
        helper.showSpinners();
        edit(editbtn)
    }
})



function edit(elm)
{
    let editurl = elm.dataset.href;
    helper.showSpinners();
    fetch(editurl,
        {
            method: "POST"
        }).then(register=>register.text())
        .then(data=>{

            // delete any edit form before add new ones
            let editformmodal = document.getElementById('editmodal');
            if(editformmodal)
            {
                editformmodal.remove();
            }
            wraper.insertAdjacentHTML("beforeend" , data)
            helper.clearResultError();
            helper.hideSpinners();
            if(document.getElementById('editmodal'))
            {
                var editmodal = new bootstrap.Modal(document.getElementById('editmodal'), option);
            }
            editmodal.toggle()
            // update
            let editform = document.querySelector(".edit-form");
            let updatebtn = document.querySelector(".update");
            if(updatebtn)
            {
                updatebtn.addEventListener("click",()=>
                {
                    helper.showSpinners();
                    let updateurl = updatebtn.dataset.target;
                    update(updateurl,editform,editmodal)
                    
                })
            }
        })
}

function update(url,form,modal)
{
    let data = new FormData(form);
    fetch(url,
        {
            method: "POST",
            body : data
        }).then(res=>res.json()).
        then(data=>{
            helper.clearResultError();
            if(data.suc)
            {   helper.hideSpinners();  
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 1000
                });
                modal.toggle();
                console.table(data.results)
                loadTable(data.results);
            }else if(data.err)
            {
                helper.hideSpinners();
                for (const key in data.err) 
                {
                    
                    document.querySelector(`.edit-form .${key}`).style.display = "block";
                    document.querySelector(`.edit-form .${key}`).innerHTML = data.err[key];
                }
            }
        });
}

// delete 

document.addEventListener("click",e=>
{
    if(e.target.classList.contains("delete"))
    {

        let  deletebtn = e.target;
        deleteitem(deletebtn)
    }
})

function deleteitem(elm)
{
    let deleteurl = elm.dataset.href;
    swal({
        "text": "are you sure to delete" , 
        icon: "warning",
        dangermode: true,
        buttons: [true , "yes"]
    })
    .then(resp=>{
        if(resp)
        {
            fetchdelete(deleteurl)
        }
    })
}

function fetchdelete(url)
{
    fetch(url,
        {
            method: "POST",
        }).then(res=>res.json()).
        then(data=>{
            if(data.suc)
            {     
                swal({
                    "text" : data.suc , 
                    "icon" : "success",
                    "button" : false,
                    timer: 1000
                });
                loadTable(data.results);

            }else if(data.err)
            {
                swal({
                    "text" : data.err , 
                    "icon" : "error",
                    "button" : false,
                    timer: 1000
                }); 
            }
        });
}





function loadTable(results)
{
    let table = document.querySelector(".table");
    let tbody = table.querySelector(".tbody");
    tbody.innerHTML= "";
    let trTag = "";
    if(Object.keys(results).length != 0)
    {
        for(let result of results)
        {
            trTag += `
                <tr>
                    <td>
                        ${result['userName']}
                    </td>
                    <td>
                        ${result['email']}
                    </td>
                    <td>
                        ${result['mobile']}
                    </td>
                    <td>
                        ${result['lastLogin']}
                    </td>
                    <td>
                        ${result['subscriptionDate']}
                    </td>
                    <td>
                        ${result['groupName']}
                    </td>
                    <td class='action'>
                    <button data-href="/chat/users/edit/${result['userId']}" class="btn btn-primary btn-sm edit" style="margin-bottom: 3px;"><i class="fas fa-edit"></i></button>
                    <button data-href="/chat/users/delete/${result['userId']}" class="btn btn-danger btn-sm delete" style="margin-bottom: 3px;"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            `;
        }
    }

    tbody.insertAdjacentHTML("beforeend",trTag)

}

