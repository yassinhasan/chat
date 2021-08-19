let allusersdiv = document.querySelector('.all-users');
let search_now = false;
let url = "http://www.chat.com/getAllUser"; 

setInterval(function(){ 
  if(search_now == false)
  {
    fetch(url, {
      method: 'POST', // or 'PUT'
    })
    .then(response => response.json())
    .then(data => {
      if(data.error)
      {
        console.log('no users')
      }
      if(data.users)
      {
        
        allusersdiv.innerHTML = "";  
        for(let user of data.users)
        {
         
          let  timeinjs  = new Date();
          timeinjs  = Math.round(timeinjs.getTime()/ 1000);
          let status = (timeinjs -  user.logintime > 10) ? 'offline' : '';
          allusersdiv.innerHTML +=`<a href="http://www.chat.com/userchat/${user.unique_id}" class='user'>
          <div class='main-info'>
                <div class='info'>
                    <div>
                    <img src='public\\chat\\uploades\\images\\${user.image}'>
                    </div>
                    <div class='info-items'>
                        <p>${user.firstname} ${user.lastname}</p>
                        <p> ${user.msg}</p>
                    </div>
                </div>
            <p class='dot ${status}'>  </p>
            </div>
          </a>`;
        
        }
      }
    })
    .catch((error) => {
      console.error('Error:', error);
    });
  }
   }, 3000);
if(search_now == false)
{
  fetch(url, {
    method: 'POST', // or 'PUT'
  })
  .then(response => response.json())
  .then(data => {
    

    if(data.error)
    {
      console.log('no users')
    }
    if(data.users)
    {

      allusersdiv.innerHTML = "";  

      for(let user of data.users)
      {

        let  timeinjs  = new Date();
        timeinjs  = Math.round(timeinjs.getTime()/ 1000);
        let status = (timeinjs -  user.logintime > 3) ? 'offline' : '';
        allusersdiv.innerHTML +=`<a href="http://www.chat.com/userchat/${user.unique_id}" class='user'>
        <div class='main-info'>
              <div class='info'>
                  <div>
                  <img src='public\\chat\\uploades\\images\\${user.image}'>
                  </div>
                  <div class='info-items'>
                      <p>${user.firstname} ${user.lastname}</p>
                      <p> ${user.msg}</p>
                  </div>
              </div>
              <p class='dot ${status}'>  </p>
          </div>
        </a>`;
      
      }
    }
  })
  .catch((error) => {
    console.error('Error:', error);
});
}

// search 
let form      = document.querySelector(".form"),
    search_url       = form.getAttribute("action");
    search = document.querySelector('.search');


search.addEventListener("keyup",()=>
{

  search_now = true;
  data = new FormData(form)
  if(search_now == true)
  {
    fetch(search_url, {
      method: 'POST', // or 'PUT'
      body: data,
    })
    .then(response => response.json())
    .then(data => {
      if(data.users)
      {
        allusersdiv.innerHTML = "";  
        for(let user of data.users)
        {
          // let login time = 7 // current login == 7,15 
          // if current login - login time > 1 min so he if offline
          {
            let  timeinjs  = new Date();
            timeinjs  = Math.round(timeinjs.getTime()/ 1000);
            let status = (timeinjs -  user.logintime > 10) ? 'offline' : '';
            allusersdiv.innerHTML +=`<a href="http://www.chat.com/userchat/${user.unique_id}" class='user'>
            <div class='main-info'>
                  <div class='info'>
                      <div>
                      <img src='public\\chat\\uploades\\images\\${user.image}'>
                      </div>
                      <div class='info-items'>
                          <p>${user.firstname} ${user.lastname}</p>
                          <p class='user-msg'> Lorem ipsum dolor  Lorem ipsum dolo sit ...</p>
                      </div>
                  </div>
              <p class='dot ${status}'>  </p>
              </div>
            </a>`;
          
          }
        
        }
      }

    })
    .catch((error) => {
      console.error('Error:', error);
    });    
  }

})




window.addEventListener("beforeunload",()=>
{

    fetch('http://www.chat.com/end', {
      method: 'POST', // or 'PUT'
    })
    .then(response => response.json())
    .then(data => {
      // if(data.suc)
      // {
      //   console.log("suc")
      // }

    })


    .catch((error) => {
      console.error('Error:', error);
    });    

})

