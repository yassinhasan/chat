import  * as helper from "/chat/Public/js/helper.js";

// profile info 
let edit_btn_profile = document.querySelector(".edit_btn_profile");
let cancel_Profile_Btn = document.querySelector(".cancel_Profile_Btn");
let profile_form_wraper = document.querySelector(".profile_form_wraper");
let profile_form = document.querySelector(".profile_form");
let profile_card = document.querySelector(".profile_card");


        //profile show form
edit_btn_profile.addEventListener("click",(e)=>
{
    e.preventDefault();
    profile_form_wraper.style.display = "block" ;
    window.scrollTo(0 , profile_form_wraper.offsetTop - profile_form_wraper.clientHeight )
    profile_card.style.display = "none";
    
})
            //profile hide form
cancel_Profile_Btn.addEventListener("click",(e)=>
{
    e.preventDefault();
    profile_form_wraper.style.display = "none" ;
    profile_card.style.display = "block";
    window.scrollTo(0 , profile_form_wraper.offsetTop - profile_form_wraper.clientHeight )
    
})

            // save profile 
let save_profile  =  document.querySelector(".save_profile");
let save_Profile_Url = save_profile.getAttribute("data-target");
save_profile.addEventListener("click",()=>
{
    helper.showSpinners();
    let dataToSend = new FormData(profile_form);
    loadModel( save_Profile_Url , dataToSend ,  profile_card ,profile_form ,cancel_Profile_Btn , true)
})

// save contact info
let edit_btn_contact = document.querySelector(".edit_btn_contact");
let cancel_Btn_contact = document.querySelector(".cancel_Btn_contact");
let contact_form_wraper = document.querySelector(".contact_form_wraper");
let contact_form = document.querySelector(".contact_form");
let contact_card = document.querySelector(".contact_card");

//contact

        //  show contact form
edit_btn_contact.addEventListener("click",(e)=>
{
    e.preventDefault();
    contact_form_wraper.style.display = "block" ;
    contact_card.style.display = "none";
    
})
        //  hide contact form
cancel_Btn_contact.addEventListener("click",(e)=>
{
    e.preventDefault();
    contact_form_wraper.style.display = "none" ;
    contact_card.style.display = "block";
    
})

        //senddata contat form 
let save_Contact_Info  =  document.querySelector(".save_Contact_Info");

let saveContactUrl = save_Contact_Info.getAttribute("data-target");

save_Contact_Info.addEventListener("click",()=>
{
    helper.showSpinners();
    let dataToSend = new FormData(contact_form);
    loadModel(saveContactUrl ,dataToSend ,   contact_card ,   contact_form , cancel_Btn_contact ,true)
})

// save security info  
let edit_btn_security = document.querySelector(".edit_btn_security");
let cancel_Btn_security = document.querySelector(".cancel_Btn_security");
let security_form_wraper = document.querySelector(".security_form_wraper");
let security_form = document.querySelector(".security_form");
let security_card = document.querySelector(".security_card");

        //security show form

edit_btn_security.addEventListener("click",(e)=>
{
    e.preventDefault();
    helper.clearResultError();
    security_form_wraper.style.display = "block" ;
    window.scrollTo(0 , security_form_wraper.offsetTop - security_form_wraper.clientHeight )
    security_card.style.display = "none";
    helper.clearResultError();
    
})
         //security hide form
cancel_Btn_security.addEventListener("click",(e)=>
{
    e.preventDefault();
    security_form_wraper.style.display = "none" ;
    security_card.style.display = "block";
    
})

        //send securoty form
let save_security_info  =  document.querySelector(".save_security");

let save_Security_Url = save_security_info.getAttribute("data-target");


save_security_info.addEventListener("click",()=>
{
    helper.showSpinners();
    let dataToSend = new FormData(security_form);
    loadModel(save_Security_Url ,dataToSend ,   security_card , security_form , cancel_Btn_security ,false)
})




function loadModel(url,dataToSend , card , form ,cancelButton , loadData)
{
    fetch(url,
        {
            method: "POST",
            body : dataToSend
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
                    timer: 1400
                });
                
                loadCardInfo(card , data.updated , loadData );
                cancelButton.click();

            }else if(data.err)
            {  

                helper.hideSpinners();
                for (const key in data.err) {
                    if(key == "image")
                    {
                        form.querySelector(`.${key}`).innerHTML = ""; 
                        for (const imageerror in data.err.image)
                        {
                            form.querySelector(`.${key}`).innerHTML += `${data.err.image[imageerror]}<br>`;                             
                        }

                    }else
                    {
                    form.querySelector(`.${key}`).innerHTML = data.err[key];                        
                    }
                 form.querySelector(`.${key}`).style.display = "block";    

                }
            }
        });
}

function loadCardInfo(wraper, data , loadData = true)
{

        if(loadData == true)
        {
            let dataKeys = Object.keys(data);
            for(let cardinfo of dataKeys)
            {
                if(cardinfo == "image" && cardinfo !== null)
                {
                      let image = data.image == null ? "avatar.jpeg" : data.image;
                      let imageProfiles = document.querySelectorAll(".profile-img img");
                      let imgSrc= imageProfiles[0].getAttribute("data-src");
                      imageProfiles.forEach(imageProfile=>
                        {
                            imageProfile.src = `${imgSrc}${image}`
                        })
                }else
                {
                    wraper.querySelector(`.card_info_${cardinfo}`).innerHTML = data[`${cardinfo}`]                       
                }
                
            
            }                  
        }else
        {
            return ;
        }
  
}



let profileImage = document.querySelector(".profile-img img.edit");
let profileImageInput = document.querySelector(".profile_input");
profileImage.addEventListener("click",()=>
{
    profileImageInput.click();
})
let editProfileImage = document.querySelectorAll(".profile-img img")[1];
profileImageInput.addEventListener("change",(e)=>
{
    let file = e.target.files[0];
    let fileReader = new FileReader()
    fileReader.addEventListener('load', ()=>{
        editProfileImage.src =  fileReader.result
    });
    fileReader.readAsDataURL(file);
})