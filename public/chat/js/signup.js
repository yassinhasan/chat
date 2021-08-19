let form      = document.querySelector(".form"),
    submitbtn = document.querySelector(".submit"),
    result    = document.querySelector(".result");


    submitbtn.addEventListener("click",(e)=>
    {
        e.preventDefault();
        let url = form.getAttribute("action");
        let data = new FormData(form);
        
        fetch(url, {
            method: 'POST', // or 'PUT'
            body: data,
          })
          .then(response => response.json())
          .then(data => {
            if(data.error)
            {
              result.classList.remove("success");
              result.classList.add("error");
              result.innerHTML = data.error
            }
            if(data.success)
            {
              result.classList.add("success");
              result.classList.remove("error");
              result.innerHTML = data.success
              window.location.href = data.redirect
            }
          })
          .catch((error) => {
            console.error('Error:', error);
          });
    })