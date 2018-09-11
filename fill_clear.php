<?php
    include("bd.php");
    if (isset($_POST['clear'])){
?>
<script>
    function setCookie(name, value, options) {
    options = options || {};
    
    var expires = options.expires;
    
    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }
    
    value = encodeURIComponent(value);
    
    var updatedCookie = name + "=" + value;
    
    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    
      document.cookie = updatedCookie;
    }
    
    setCookie('userName', "", {expires: -1});
    setCookie('status', "", {expires: -1});
</script>
<?php
        mysql_query("DELETE FROM `files`");
        mysql_query("DELETE FROM `files-users`");
        mysql_query("DELETE FROM `queue`");
        mysql_query("DELETE FROM `requests`");
        mysql_query("DELETE FROM `returns`");
        mysql_query("DELETE FROM `users`");
        mysql_query("DELETE FROM `log`");
        
        echo '<script>alert("Database has been reset");window.location.replace("test.php");</script>';
    } 
    else if (isset($_POST['fill-demo'])){
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, img_link, tags) VALUES('Touch of class','Bertrand Meyer','No','Book','Springer, 2010','From object technology pioneer and ETH Zurich professor Bertrand Meyer, winner of the Jolt award and the ACM Software System Award, a revolutionary textbook that makes learning programming fun and rewarding. Meyer builds his presentation on a rich object-oriented software system supporting graphics and multimedia, which students can use to produce impressive applications from day one, then understand inside out as they learn new programming techniques. Unique to Touch of Class is a combination of a practical, hands-on approach to programming with the introduction of sound theoretical support focused on helping students learn the construction of high quality software. The use of full color brings exciting programming concepts to life. Among the useful features of the book is the use of Design by Contract, critical to software quality and providing a gentle introduction to formal methods. Will give students a major advantage by teaching professional-level techniques in a literat','7','500','https://images-na.ssl-images-amazon.com/images/I/51Smxoj5d5L.jpg', 'book')");
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, img_link, tags) VALUES('Fifty shades of grey','E.L.James','Yes','Book','Vintage Books, 2011','When literature student Anastasia Steele goes to interview young entrepreneur Christian Grey, she encounters a man who is beautiful, brilliant, and intimidating. The unworldly, innocent Ana is startled to realize she wants this man and, despite his enigmatic reserve, finds she is desperate to get close to him. Unable to resist Ana’s quiet beauty, wit, and independent spirit, Grey admits he wants her, too—but on his own terms.   Shocked yet thrilled by Grey’s singular erotic tastes, Ana hesitates. For all the trappings of success—his multinational businesses, his vast wealth, his loving family—Grey is a man tormented by demons and consumed by the need to control. When the couple embarks on a daring, passionately physical affair, Ana discovers Christian Grey’s secrets and explores her own dark desires.  This book is intended for mature audiences.','8','1000','https://images-na.ssl-images-amazon.com/images/I/81kcUYzbWoL.jpg', 'book')");
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, img_link, tags) VALUES('Fifty shades darker','E.L.James','No','Book','Vintage Books, 2012','Daunted by the singular tastes and dark secrets of the beautiful, tormented young entrepreneur Christian Grey, Anastasia Steele has broken off their relationship to start a new career with a Seattle publishing house. But desire for Christian still dominates her every waking thought, and when he proposes a new arrangement, Anastasia cannot resist. They rekindle their searing sensual affair, and Anastasia learns more about the harrowing past of her damaged, driven and demanding Fifty Shades. While Christian wrestles with his inner demons, Anastasia must confront the anger and envy of the women who came before her, and make the most important decision of her life. This book is intended for mature audiences. ','62','1000','https://m.media-amazon.com/images/I/51dUzKjbDBL._SL500_.jpg', 'book')");
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, img_link, tags) VALUES('Fifty shades freed','E.L.James','Yes','Book','Vintage Books, 2018','When unworldly student Anastasia Steele first encountered the driven and dazzling young entrepreneur Christian Grey it sparked a sensual affair that changed both of their lives irrevocably. Shocked, intrigued, and, ultimately, repelled by Christian\'s singular erotic tastes, Ana demands a deeper commitment. Determined to keep her, Christian agrees. Now, Ana and Christian have it all--love, passion, intimacy, wealth, and a world of possibilities for their future. But Ana knows that loving her Fifty Shades will not be easy, and that being together will pose challenges that neither of them would anticipate. Ana must somehow learn to share Christian\'s opulent lifestyle without sacrificing her own identity. And Christian must overcome his compulsion to control as he wrestles with the demons of a tormented past. Just when it seems that their strength together will eclipse any obstacle, misfortune, malice, and fate conspire to make Ana\'s deepest fears turn to reality. This book is int','0','1000','https://d1w7fb2mkkr3kw.cloudfront.net/assets/images/book/large/9781/8465/9781846573804.jpg', 'book')");
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, tags) VALUES('Rate of happiness in modern society','I.M.Smart','Yes','Article','Very Science, 2017','Society is very happy','3','300', 'article')");
        mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, img_link, tags) VALUES('Life of the animals','Elon Musk','Yes','AV-file','Such science, 2018','Animals are cute','4','150','https://sun9-3.userapi.com/c840526/v840526262/6ee27/KD3rhCYiLxg.jpg', 'av-file')");
        
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, img_link) VALUES('yaya1@ya.ya','yaya','Ya Ya','Yayaisk','2281488','Librarian-1','http://y98722gq.beget.tech/img/meyer.jpg')");
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, img_link) VALUES('yaya2@ya.ya','yaya','Ya Ya','Yayaisk','2281488','Librarian-2','http://pm1.narvii.com/6436/36af7a779aed04371d6cefbfae13a65c9d97af20_hq.jpg')");
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, img_link) VALUES('yaya3@ya.ya','yaya','Ya Ya','Yayaisk','2281488','Librarian-3','http://i0.kym-cdn.com/photos/images/original/001/283/749/ec9.png')");
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, img_link) VALUES('admin@a.a','admin','Big Boss','Nizhnevartovsk','2281488','Admin','https://i.ytimg.com/vi/IZIed2M0Gq8/maxresdefault.jpg')");
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, img_link) VALUES('irek_nazmiev@mail.ru','irek','irek','Brave new world','01134','Student','https://s8.hostingkartinok.com/uploads/images/2018/04/fffbf704f5a15834411b4e4fd1ffcc77.jpg')");
    
        echo '<script>alert("Database has been filled for demo.");window.location.replace("test.php");</script>';
    }
    else if (isset($_POST['fill-tests'])){
        mysql_query ("INSERT INTO users (login, password, name, address, phone, status, id, img_link) VALUES('admin@a.a','admin','Big Boss','Nizhnevartovsk','2281488','Admin', '1208', 'http://www.adbazar.pk/frontend/images/default-image.jpg')");
        echo '<script>alert("Database has been filled for tests.");window.location.replace("test.php");</script>';
    }
?>