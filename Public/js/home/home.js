

let innerwraper = document.querySelector(".inner-wraper");
let privatewraper = document.querySelector(".private-wraper");
let wraperheader = document.querySelector(".wraper-header");
let chatfooter = document.querySelector(".chat-footer");
let privatechatfooter = document.querySelector(".privatechat-footer");
let wrapersearch = document.querySelector(".wraper-search"); 
let msgarea = document.querySelector(".msgarea"); 
let msgarea_wraper = document.querySelector(".msgarea-wraper"); 
let token = wraperheader.getAttribute("data-token");
let profilepath = wraperheader.getAttribute("data-profilepath");
let app_chat_path = wraperheader.getAttribute("data-app_chat_path");
let chatarea = document.querySelectorAll(".chat-area"); 
let wrapercontact = document.querySelector(".wraper-contacts"); 
let wrapercontact_url = wrapercontact.getAttribute("data-url");
let saveChat_url = wraperheader.getAttribute("data-saveFiles");
let backtochat = document.querySelector(".private-chat-info .backtochat");
let chatprivatearea = document.querySelector(".private-chat-area");
let uploadbtn = document.querySelector(".upload");
let to = {};
let userData = {};
userData.loggeduser = wraperheader.getAttribute("data-userId");
let logoutbtn = document.querySelector(".logout-chat");
let logout_url = logoutbtn.getAttribute("data-href");
//SEND CHAT
let fromId = wraperheader.getAttribute("data-userId");



//update headers log or not  log
function updateheaders()
{
    let datasend = new FormData();
    datasend.append("loggeduser" , fromId)
    fetch(wrapercontact_url ,
        {
            method: "POST" ,
            body  :  datasend
        }).then(rep=>rep.json())
        .then(data=>{
            wrapercontact.innerHTML = "";
            let innerhtml = "";
            let allusers = data.allusers
            if(allusers.length > 0 )
            {
                for(let x = 0 ; x <  allusers.length ; x ++)
                {
                    let image = allusers[x].image == null ? "avatar.jpeg" : allusers[x].image
                    innerhtml+= `
                    <div data-name = "${allusers[x].userName}" data-userId="${allusers[x].userId}">
                        <img src="${profilepath}${image}" alt="profile-pic" class="">
                        <p class="name">${allusers[x].userName}</p>
                        <i class="fas fa-circle ${allusers[x].status}" data-status="${allusers[x].status}"></i>
                    </div>
                    `
                }
                wrapercontact.innerHTML = innerhtml;
                let wrapercontacts = document.querySelectorAll(".wraper-contacts > div");
                wrapercontactsOnClick(wrapercontacts) 
            }
        })
}
function wrapercontactsOnClick(wrapercontacts)
{
    wrapercontacts.forEach(el=>
        {
            
            removeActive(wrapercontacts)
            el.addEventListener("click",(e)=>
            {
            
                el.classList.add("active");
                let chatname = el.getAttribute("data-name");
                let status = el.querySelector(".fa-circle");
                status = status.getAttribute("data-status")
                let imagesrc = el.querySelector("img").src;
                showPrivateChat( chatname , imagesrc ,status); 
                let fromId = userData.loggeduser;
                let toId = el.getAttribute("data-userId");
                to.toId = toId;
                let urlMessages = wraperheader.getAttribute("data-loadchat");
                //fetch all messages
                chatprivatearea.innerHTML = "";
                fetchAllMessages(el , urlMessages , fromId , toId)
            
            })
    })
}
updateheaders()
// when scroll add sticky class on header
innerwraper.addEventListener("scroll",()=>
{
    if(innerwraper.scrollTop > 10)
    {
          wraperheader.classList.add("sticky") 
    }else
    {
             wraperheader.classList.remove("sticky") 
    }

 
})
//
function removeActive(elments){
    elments.forEach(el=>{
        el.classList.remove("active")
    })
}


const conn= new WebSocket("wss://port-8000-php-yassin-smsmhasan158145.preview.codeanywhere.com/chat/home?"+token);
conn.onopen = function(e) {
    console.log("Connection established!");
    try {
    //when log in 

        let msg = {};
        msg.command = "login";
        msg.userId = fromId;
        conn.send(JSON.stringify(msg))
    } catch (error) {
        console.log("err")
    }
};

conn.onmessage  = (e)=>
{
  
    
    let returnedData = JSON.parse(e.data);
    

    if(returnedData)
    {
        if(document.querySelector(".no-chat"))
        {
            document.querySelector(".no-chat").remove()
        } 
        let classdiv= "";
        let from ="";
        if(returnedData.from !== "Me")
        {
            classdiv = "to row justify-content-start";
            from = returnedData.from;
        }else
            {
                classdiv = "from row justify-content-end";
                from = "ME";
            }
            let msg = `<div class="${classdiv}">
                                <div class="content">
                                    <span>${from}</span>: <span>${returnedData.msg}</span><p class="created text-end">${returnedData.created}
                                    </p>
                                </div>
            </div>`;            
        chatprivatearea.innerHTML += msg;
        chatprivatearea.scrollTop = (chatprivatearea.scrollHeight) ;
        loadChatAtHomePageExceptLoggedUser();
        updateheaders()
    }
   
}

conn.onclose = (e)=>
{
    loadChatAtHomePageExceptLoggedUser();
    updateheaders()
}


//when logout
logoutbtn.addEventListener("click",(e)=>
{
    let msg = {};
    msg.command = "close";
    msg.userId = fromId;
   conn.send(JSON.stringify(msg))
   window.location.href = logout_url
})

// when need to upload file
// on drop file in textarea

msgarea.addEventListener("dragenter",(e)=>
{
    msgarea.classList.add("active");
    e.stopPropagation();
    e.preventDefault();
})
msgarea.addEventListener("dragover",(e)=>
{
    e.stopPropagation();
    e.preventDefault();

})

msgarea.addEventListener("dragleave",(e)=>
{
    msgarea.classList.remove("active");
    
})
let hiddenfile = document.querySelector(".hidden-file");
let alreadyhavedropedfile = false;

msgarea.addEventListener("drop",(e)=>
{
    e.stopPropagation();
    e.preventDefault();
    msgarea.classList.remove("active")
    const dt = e.dataTransfer;
    const files = dt.files;
    hiddenfile.files =  files ;
    if(files.length > 1 || alreadyhavedropedfile == true)
    {
        return;
    }else
    {
        msgarea.setAttribute("contenteditable" , false)
        let innerhtml = "";
        for(let x = 0 ; x < files.length ; x++)
        {
            innerhtml = `
                        <div class="dropped dropeed-file" contenteditable="false" >
                        <span class="droped">${files[x].name}</span>
                        <span class="droped">${files[x].size}</span>
                        <span class="close">x</span>
                        </div>
                       
            `;
        }

        innerhtml += ` <div class="textarea_to_send" contenteditable="true" style="outline:none"></div>` 

        msgarea.innerHTML += innerhtml; 
        alreadyhavedropedfile = true;
        let closedropedfile = document.querySelector(".dropeed-file .close");
        if(closedropedfile)
        {
            closedropedfile.addEventListener("click",(e)=>
            {
                resize()
                closedropedfile.parentElement.remove();
            })
        }
    }

})

// click on uplaod 
uploadbtn.addEventListener("click",(e)=>
{
    e.preventDefault();
    hiddenfile.click();
    hiddenfile.addEventListener("change",(e)=>
    {
        let files = e.target.files[0];
        if(files.length > 1)
        {
            return ;
        }else
        { 
            msgarea.setAttribute("contenteditable" , false)
            msgarea.innerHTML = `
                            <div class="dropped uploaded-dropped" contenteditable="false" >
                            <span class="droped-name">${files.name}</span>
                            <span class="droped-size">${files.size}</span>
                            <span class="close">x</span>
                            </div>
                           <div class="textarea_to_send" contenteditable="true" style="outline:none"></div>
                `;
                let closedropedfile = document.querySelector(".uploaded-dropped .close");
                closedropedfile.onclick = ()=>{
                    closedropedfile.parentElement.remove()
                }

        }
    })
    alreadyhavedropedfile = true;

})


let progresspane = document.querySelector(".progress span")
let sendChatBtn = document.querySelector(".send");
sendChatBtn.addEventListener("click",()=>
{
    
    msgarea.setAttribute("contenteditable" , true)
    let msg = "";
    let msgToSend  = document.querySelector(".textarea_to_send");
    if(msgToSend)
    {
        msg = msgToSend.innerHTML;
    }else
    {
        msg = msgarea.innerHTML;
    }
    let toId = to.toId;

    if(msg != "" || alreadyhavedropedfile == true)
    {
        let form = document.querySelector(".chat-form");
        let filetosend = new FormData(form);
        filetosend.append("fromId" , fromId)
        filetosend.append("toId" , toId)
        filetosend.append("msg" , msg)
        let request = new XMLHttpRequest();
        request.open('POST', saveChat_url); 
        // upload progress event
        if(alreadyhavedropedfile)
        {
            request.upload.addEventListener('progress', function(e) {
                // upload progress as percentage    
            let percent_completed = (e.loaded / e.total)*100;
            progresspane.style.width = percent_completed+"%"
                
            });
                    // request finished event
            request.addEventListener('load', function(e) {
                // HTTP status message (200, 404 etc)
                // request.response holds response from the server
                let result =JSON.parse(request.response);
                if(result.suc == "done")
                {

                    progresspane.innerHTML = "file is sent succsufuuly";
                    setTimeout(function()
                    {
                            progresspane.style.width = "0%";
                            progresspane.innerHTML = ""

                    } , 1000)
                    
                }
            });
        }else
        {
            request.addEventListener('load', function(e) {
                let result =JSON.parse(request.response);
                if(result.suc == "done")
                {
                    makeChatArea(result.allmsg , toId)
                }
            });
        }
        // send POST request to server
        request.send(filetosend);
        
    }
    //test
    if(msg !== "" && conn.readyState == 1)
    {

        conn.send(JSON.stringify({
                "msg" : msg , 
                "fromId" : fromId , 
                "toId" :toId ,
                "command" : "private" ,
        }))

    }
    msgarea.innerHTML="";
    msgarea.style.height = 'auto';
    loadChatAtHomePageExceptLoggedUser()
});



backtochat.addEventListener("click",()=>
{
    let wrapercontacts = document.querySelectorAll(".wraper-contacts > div");
    removeActive(wrapercontacts)
    loadChatAtHomePageExceptLoggedUser()
    showChatHome()
})


function fetchAllMessages(el , url , fromId , toId)
{
    
    let form = new FormData();
    form.append("fromId" , fromId);
    form.append("toId" , toId);
    if(el.classList.contains("active"))
    {
        fetch(url,{
            method: "POST" , 
            "body" : form
            })
            .then(rep=>rep.json())
            .then(data=>
                {
                    makeChatArea(data.allmsg , toId)
        })
    }
}

function makeChatArea( data , toId)
{
    // here work
    let msgs = "";
    let datalength = data.length;
    if(datalength > 0)
    {
        for(let x = 0 ; x <  data.length ; x ++)
        {
        let classdiv= "";
        let from ="";
        if(data[x].fromId == toId)
        {
            classdiv = "to row justify-content-start";
            from = data[x].userName;
        }else
        {
                classdiv = "from row justify-content-end";
                from = "ME";
        }
        // if msg has attatchment
        if(data[x].has_attachment == 1)
        {
           
            if(data[x].attachment_type == "image")
            {
                msgs += `<div class="${classdiv}" id="to-${x}">
                <div class="content">
                    <span>${from}</span>: <span>${data[x].msg}</span><p class="created text-end">${data[x].created}
                    </p>
                    <img src="${app_chat_path}${data[x].fromId}-${data[x].toId}/${data[x].attachment}" class="attachment-image">
                </div>
                </div>`;     
            }else
            {
                msgs += `<div class="${classdiv}" id="to-${x}">
                <div class="content">
                    <span>${from}</span>: <span>${data[x].msg}</span><p class="created text-end">${data[x].created}
                    </p>
                    <a href="${app_chat_path}${data[x].fromId}-${data[x].toId}/${data[x].attachment}" class="attachment-link" download>${data[x].attachment}</a>
                </div>
                </div>`;  
            }

        }else
        
            msgs += `<div class="${classdiv}" id="to-${x}">
                        <div class="content">
                            <span>${from}</span>: <span>${data[x].msg}</span><p class="created text-end">${data[x].created}
                            </p>
                        </div>
            </div>`;              
        }

        chatprivatearea.innerHTML = msgs;        
    }else
    {
        chatprivatearea.innerHTML = `<div class="row justify-content-center no-chat">not chat yet</div>`;
    }
    chatprivatearea.scrollTop = (chatprivatearea.scrollHeight) ;

    let attachment_image = document.querySelector(".attachment-image");
    if(attachment_image)
    {
        attachment_image.addEventListener("click",(e)=>
        {
            window.open(attachment_image.src , "_blank")
        })
    }
}

let oldHeight ;


function showChatHome()
{
    innerwraper.classList.remove("hide");
    privatewraper.classList.remove("show");
    chatfooter.classList.remove("hide");
    privatechatfooter.classList.remove("show");
}

function showPrivateChat(name , src , status )
{
    document.querySelector(".chatname").textContent = " "+name;
    document.querySelector(".reciever-info img").src = src;
    let icon  = document.querySelector(".reciever-info svg");
    icon.classList = "fa fa-circle "+status;
    innerwraper.classList.add("hide");
    privatewraper.classList.add("show");
    chatfooter.classList.add("hide");
    privatechatfooter.classList.add("show");
    oldHeight = 60;
}
function loadChatAtHomePageExceptLoggedUser()
{
    let wraperchatarea = document.querySelector(".wraper-chat-area");
    let chatarea = document.querySelector(".chat-area");
    let url = wraperchatarea.getAttribute("data-loadallaexcpetlogged");
    let form = new FormData();
    form.append("loggeduser" , userData.loggeduser);
    var myHeaders = new Headers();
    myHeaders.append('pragma', 'no-cache');
    myHeaders.append('cache-control', 'no-cache');
    fetch(url,{
        method: "POST" , 
        body : form ,
        headers : myHeaders
    }).then(rep=>rep.json())
    .then(data=>
        {
            chatarea.innerHTML = "";
            let chatareainner = "";
            
          let all =   data.getAllUserExcpetLogin.sort(function(a,b){
              return b.modified - a.modified
          })
          for(let user of all)
          {
            let openUnreadClass = user.count == 0 ? 'read' : 'unread' ;
            let image = user.image != null ? user.image : "avatar.jpeg";
            let msg = user.msg != null ? user.msg.msg : "no chat yet";
            let created = user.msg != null ? user.msg.created : "";
            chatareainner += `
                <li data-name="${user.firstName}${user.lastName}" data-status="${user.status}" data-userId="${user.userId}" class="lastcontacts">
                    <div class="profile-pic">
                        <img src="${data.imagesrc}${image}" alt="profile-pic" class="userimage">
                        <i class="fas fa-circle ${user.status}"></i>${user.count == 0 ? "" : "<span class='count'>"+user.count+"</span>"}
                    </div>
                    <div class="details-area">
                        <div class="details-area-wraper ${openUnreadClass}">
                            <div class="name">
                                <span>${user.firstName} ${user.lastName}</span>    
                            </div>
                            <div>
                                <span class="msg">${msg}</span>
                                <p class="date">${created}</p>
                            </div>
                    </div>
                    </div>
                </li>
            `
          }
          chatarea.innerHTML = chatareainner;
          let lastConactsWithMsg = document.querySelectorAll(".lastcontacts");
            if(lastConactsWithMsg)
            {
                lastConactsWithMsg.forEach(el=>
                    {
                        el.addEventListener("click",(e)=>
                        {
                            el.classList.add("active");
                            let chatname = el.getAttribute("data-name");
                            let status = el.querySelector(".fa-circle");
                            status = el.getAttribute("data-status")
                            let imagesrc = el.querySelector(".userimage").src;
                            showPrivateChat( chatname , imagesrc ,status); 
                            let fromId = userData.loggeduser;
                            let toId = el.getAttribute("data-userId");
                            to.toId = toId;
                            let urlMessages = wraperheader.getAttribute("data-loadchat");
                            //fetch all messages
                            chatprivatearea.innerHTML = "";
                            fetchAllMessages(el , urlMessages , fromId , toId);
                        })
                });
            }
            })
}
loadChatAtHomePageExceptLoggedUser()

const observer =  (elm , event , handler)=>
{
    elm.addEventListener(event,handler)
}

const resize = ()=>
{
    let maxHeight = 120;
    let newHeight;
    msgarea.style.height = "auto";
    newHeight = msgarea.scrollHeight;
    if(newHeight > maxHeight && newHeight > oldHeight )
     {
        msgarea.style.height = oldHeight+"px";
     }else
     {
        msgarea.style.height = msgarea.scrollHeight+"px";
        oldHeight = msgarea.scrollHeight;
     }
}

observer(msgarea,"input",resize)
observer(msgarea,"drop",resize)
observer(msgarea,"keydown",resize)
observer(msgarea,"cut",resize)
observer(msgarea,"paste",resize)




