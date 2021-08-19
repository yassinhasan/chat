let form      = document.querySelector(".form"),
    submitbtn = document.querySelector(".button-msg"),
    textareamsg = document.querySelector(".textarea-msg"),
     chat_area = document.querySelector(".chat-area"),
     scroll = false;


submitbtn.addEventListener("click",(e)=>
    {
        e.preventDefault();
        if(scroll == false)
        {
          scrollToTop();    
        }
        let url = form.getAttribute("action");
        let data = new FormData(form);
        textareamsg.value = "";
        fetch(url, {
            method: 'POST', // or 'PUT'
            body: data,
          })
          .then(response => response.json())
          .then(data => {
            if(data.error)
            {
                console.log(data.error)
            }
            if(data.success)
            {
                console.log(data.success)
            }
          })
          .catch((error) => {
            console.error('Error:', error);
          });
    })


// keep user active 
let info = document.querySelector(".info"),
    keep_active_url = info.getAttribute("data-target")
setInterval(function(){ 
      fetch(keep_active_url, {
        method: 'POST', // or 'PUT'
      })
      .then(response => response.json())
      .then(data => {
        if(data.user)
        {
          document.querySelector('.status').innerHTML = data.user.status
        }
      })
      .catch((error) => {
        
      });
 }, 3000);  

 fetch(keep_active_url, {
  method: 'POST', // or 'PUT'
})
.then(response => response.json())
.then(data => {
  if(data.user)
  {
    document.querySelector('.status').innerHTML = data.user.status
  }
})
.catch((error) => {
  
});


// keep message live 

    keep_message_url = chat_area.getAttribute("data-target");

setInterval(function(){ 
  fetch(keep_message_url, {
    method: 'POST', // or 'PUT'
  })
  .then(response => response.json())
  .then(data => {
    if(data.messages)
    {
      if(scroll == false)
      {
        scrollToTop();    
      }
      chat_area.innerHTML ="";
     for(let message of data.messages)
     {
     
      let incoming_message =   message.outgoing_id == data.incoming_id ? 
      ` <div class="incoming-msg">
      <img src='${data.tochat}${data.user.image}'><p>${message.msg}</p></div>` : '';    
      let outgoing_message =   message.outgoing_id == data.outgoing_id ? 
      ` <div class="outgoing-msg">
      <p>${message.msg}</p>
      </div>` : '';
  
      chat_area.innerHTML += incoming_message;
      chat_area.innerHTML += outgoing_message;
  
     }
    }
    else if(data.nomessages)
    {
      chat_area.innerHTML = "<p class='nomessages'>"+data.nomessages+"</p>";
    }
  })
  .catch((error) => {
    
  });
 }, 500);  


// fetch on going to chart
 fetch(keep_message_url, {
  method: 'POST', // or 'PUT'
})
.then(response => response.json())
.then(data => {
  if(data.messages)
  {
    if(scroll == false)
    {
      scrollToTop();    
    }

    chat_area.innerHTML ="";
   for(let message of data.messages)
   {
   
    let incoming_message =   message.outgoing_id == data.incoming_id ? 
    ` <div class="incoming-msg">
    <img src='${data.tochat}${data.user.image}'><p>${message.msg}</p></div>` : '';    
    let outgoing_message =   message.outgoing_id == data.outgoing_id ? 
    ` <div class="outgoing-msg">
    <p>${message.msg}</p>
    </div>` : '';

    chat_area.innerHTML += incoming_message;
    chat_area.innerHTML += outgoing_message;

   }
  }
  else if(data.nomessages)
  {
    chat_area.innerHTML = "<p class='nomessages'>"+data.nomessages+"</p>";
  }

})
.catch((error) => {
  
});




function scrollToTop()
{
  chat_area.scrollTop = chat_area.scrollHeight;
}

chat_area.addEventListener("mouseenter",()=>
{
  scroll = true;

})
chat_area.addEventListener("mouseleave",()=>
{
  scroll = false;
})

