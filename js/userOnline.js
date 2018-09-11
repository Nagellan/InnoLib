 function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
     "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
     ));
      return matches ? decodeURIComponent(matches[1]) : undefined;
    }        
    
    window.onload = function () {
        if (getCookie("status") != undefined && (getCookie("status") == "Librarian-1" || getCookie("status") == "Librarian-2" || getCookie("status") == "Librarian-3" || getCookie("status") == "Admin")) {
            var elements = document.getElementsByClassName('librarian');
            for (i = 0; i < elements.length; i++) {
                elements[i].style.display = 'inline-block';
            }
        }
        
        if (getCookie("userName") != undefined) {
            var elements = document.getElementsByClassName('shown');
            for (i = 0; i < elements.length; i++) {
                elements[i].style.display = 'inline-block';
            }
            var elements = document.getElementsByClassName('hided');
            for (i = 0; i < elements.length; i++) {
                elements[i].style.display = 'none';
            }
        }
    }