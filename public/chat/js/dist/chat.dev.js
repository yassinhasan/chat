"use strict";

var allusersdiv = document.querySelector('.all-users');
var search_now = false;
var url = "http://www.chat.com/getAllUser";
setInterval(function () {
  if (search_now == false) {
    fetch(url, {
      method: 'POST' // or 'PUT'

    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.error) {
        console.log('no users');
      }

      if (data.users) {
        allusersdiv.innerHTML = "";
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = data.users[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var user = _step.value;
            var timeinjs = new Date();
            timeinjs = Math.round(timeinjs.getTime() / 1000);
            var status = timeinjs - user.logintime > 10 ? 'offline' : '';
            allusersdiv.innerHTML += "<a href=\"http://www.chat.com/userchat/".concat(user.unique_id, "\" class='user'>\n          <div class='main-info'>\n                <div class='info'>\n                    <div>\n                    <img src='public\\chat\\uploades\\images\\").concat(user.image, "'>\n                    </div>\n                    <div class='info-items'>\n                        <p>").concat(user.firstname, " ").concat(user.lastname, "</p>\n                        <p> ").concat(user.msg, "</p>\n                    </div>\n                </div>\n            <p class='dot ").concat(status, "'>  </p>\n            </div>\n          </a>");
          }
        } catch (err) {
          _didIteratorError = true;
          _iteratorError = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion && _iterator["return"] != null) {
              _iterator["return"]();
            }
          } finally {
            if (_didIteratorError) {
              throw _iteratorError;
            }
          }
        }
      }
    })["catch"](function (error) {
      console.error('Error:', error);
    });
  }
}, 3000);

if (search_now == false) {
  fetch(url, {
    method: 'POST' // or 'PUT'

  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.error) {
      console.log('no users');
    }

    if (data.users) {
      allusersdiv.innerHTML = "";
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = data.users[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var user = _step2.value;
          var timeinjs = new Date();
          timeinjs = Math.round(timeinjs.getTime() / 1000);
          var status = timeinjs - user.logintime > 3 ? 'offline' : '';
          allusersdiv.innerHTML += "<a href=\"http://www.chat.com/userchat/".concat(user.unique_id, "\" class='user'>\n        <div class='main-info'>\n              <div class='info'>\n                  <div>\n                  <img src='public\\chat\\uploades\\images\\").concat(user.image, "'>\n                  </div>\n                  <div class='info-items'>\n                      <p>").concat(user.firstname, " ").concat(user.lastname, "</p>\n                      <p> ").concat(user.msg, "</p>\n                  </div>\n              </div>\n              <p class='dot ").concat(status, "'>  </p>\n          </div>\n        </a>");
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
            _iterator2["return"]();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }
    }
  })["catch"](function (error) {
    console.error('Error:', error);
  });
} // search 


var form = document.querySelector(".form"),
    search_url = form.getAttribute("action");
search = document.querySelector('.search');
search.addEventListener("keyup", function () {
  search_now = true;
  data = new FormData(form);

  if (search_now == true) {
    fetch(search_url, {
      method: 'POST',
      // or 'PUT'
      body: data
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.users) {
        allusersdiv.innerHTML = "";
        var _iteratorNormalCompletion3 = true;
        var _didIteratorError3 = false;
        var _iteratorError3 = undefined;

        try {
          for (var _iterator3 = data.users[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
            var user = _step3.value;
            // let login time = 7 // current login == 7,15 
            // if current login - login time > 1 min so he if offline
            {
              var timeinjs = new Date();
              timeinjs = Math.round(timeinjs.getTime() / 1000);
              var status = timeinjs - user.logintime > 10 ? 'offline' : '';
              allusersdiv.innerHTML += "<a href=\"http://www.chat.com/userchat/".concat(user.unique_id, "\" class='user'>\n            <div class='main-info'>\n                  <div class='info'>\n                      <div>\n                      <img src='public\\chat\\uploades\\images\\").concat(user.image, "'>\n                      </div>\n                      <div class='info-items'>\n                          <p>").concat(user.firstname, " ").concat(user.lastname, "</p>\n                          <p class='user-msg'> Lorem ipsum dolor  Lorem ipsum dolo sit ...</p>\n                      </div>\n                  </div>\n              <p class='dot ").concat(status, "'>  </p>\n              </div>\n            </a>");
            }
          }
        } catch (err) {
          _didIteratorError3 = true;
          _iteratorError3 = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
              _iterator3["return"]();
            }
          } finally {
            if (_didIteratorError3) {
              throw _iteratorError3;
            }
          }
        }
      }
    })["catch"](function (error) {
      console.error('Error:', error);
    });
  }
});
window.addEventListener("beforeunload", function () {
  fetch('http://www.chat.com/end', {
    method: 'POST' // or 'PUT'

  }).then(function (response) {
    return response.json();
  }).then(function (data) {// if(data.suc)
    // {
    //   console.log("suc")
    // }
  })["catch"](function (error) {
    console.error('Error:', error);
  });
});