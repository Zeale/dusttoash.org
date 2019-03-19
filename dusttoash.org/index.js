var enableScrolling = false; // For debug purposes

if (enableScrolling)
    window.onscroll = function () {
        var item = document.getElementById("Header");
        if (document.body.scrollTop > item.clientHeight) {
            item.style.position = "fixed";
            document.body.style.marginTop = item.clientHeight;
        } else if (document.body.scrollTop < item.clientHeight) {
            item.style.position = "relative";
            document.body.style.marginTop = 0;
        }

    };
