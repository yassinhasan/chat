"use strict";

var form = document.querySelector(".form"),
    submitbtn = document.querySelector(".button-msg"),
    textareamsg = document.querySelector(".textarea-msg"),
    chat_area = document.querySelector(".chat-area"),
    scroll = false;
submitbtn.addEventListener("click", function (e) {
  e.preventDefault();

  if (scroll == false) {
    scrollToTop();
  }

  var url = form.getAttribute("action");
  var data = new FormData(form);
  textareamsg.value = "";
  fetch(url, {
    method: 'POST',
    // or 'PUT'
    body: data
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.error) {
      console.log(data.error);
    }

    if (data.success) {
      console.log(data.success);
    }
  })["catch"](function (error) {
    console.error('Error:', error);
  });
}); // keep user active 

var info = document.querySelector(".info"),
    keep_active_url = info.getAttribute("data-target");
setInterval(function () {
  fetch(keep_active_url, {
    method: 'POST' // or 'PUT'

  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.user) {
      document.querySelector('.status').innerHTML = data.user.status;
    }
  })["catch"](function (error) {});
}, 3000);
fetch(keep_active_url, {
  method: 'POST' // or 'PUT'

}).then(function (response) {
  return response.json();
}).then(function (data) {
  if (data.user) {
    document.querySelector('.status').innerHTML = data.user.status;
  }
})["catch"](function (error) {}); // keep message live 

keep_message_url = chat_area.getAttribute("data-target");
setInterval(function () {
  fetch(keep_message_url, {
    method: 'POST' // or 'PUT'

  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.messages) {
      if (scroll == false) {
        scrollToTop();
      }

      chat_area.innerHTML = "";
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = data.messages[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var message = _step.value;
          var incoming_message = message.outgoing_id == data.incoming_id ? " <div class=\"incoming-msg\">\n      <img src='".concat(data.tochat).concat(data.user.image, "'><p>").concat(message.msg, "</p></div>") : '';
          var outgoing_message = message.outgoing_id == data.outgoing_id ? " <div class=\"outgoing-msg\">\n      <p>".concat(message.msg, "</p>\n      </div>") : '';
          chat_area.innerHTML += incoming_message;
          chat_area.innerHTML += outgoing_message;
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
    } else if (data.nomessages) {
      chat_area.innerHTML = "<p class='nomessages'>" + data.nomessages + "</p>";
    }
  })["catch"](function (error) {});
}, 500); // fetch on going to chart

fetch(keep_message_url, {
  method: 'POST' // or 'PUT'

}).then(function (response) {
  return response.json();
}).then(function (data) {
  if (data.messages) {
    if (scroll == false) {
      scrollToTop();
    }

    chat_area.innerHTML = "";
    var _iteratorNormalCompletion2 = true;
    var _didIteratorError2 = false;
    var _iteratorError2 = undefined;

    try {
      for (var _iterator2 = data.messages[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
        var message = _step2.value;
        var incoming_message = message.outgoing_id == data.incoming_id ? " <div class=\"incoming-msg\">\n    <img src='".concat(data.tochat).concat(data.user.image, "'><p>").concat(message.msg, "</p></div>") : '';
        var outgoing_message = message.outgoing_id == data.outgoing_id ? " <div class=\"outgoing-msg\">\n    <p>".concat(message.msg, "</p>\n    </div>") : '';
        chat_area.innerHTML += incoming_message;
        chat_area.innerHTML += outgoing_message;
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
  } else if (data.nomessages) {
    chat_area.innerHTML = "<p class='nomessages'>" + data.nomessages + "</p>";
  }
})["catch"](function (error) {});

function scrollToTop() {
  chat_area.scrollTop = chat_area.scrollHeight;
}

chat_area.addEventListener("mouseenter", function () {
  scroll = true;
});
chat_area.addEventListener("mouseleave", function () {
  scroll = false;
});