    <?php include '../../helper/url.php'; ?>
    <script src="<?php echo $urlAsset ?>js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $urlAsset ?>scripts/main.js"></script>
    <script src="<?php echo $urlAsset ?>scripts/alert.js"></script>
    <script src="<?php echo $urlAsset ?>node_modules/ckeditor4/ckeditor.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.3/datatables.min.js"></script>
    <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <script language="javascript">
// window.history.forward(1);
// To disable right click
document.addEventListener('contextmenu', event => event.preventDefault());

// To disable F12 options
document.onkeypress = function(event) {
    event = (event || window.event);
    if (event.keyCode == 123) {
        return false;
    }
}
document.onmousedown = function(event) {
    event = (event || window.event);
    if (event.keyCode == 123) {
        return false;
    }
}
document.onkeydown = function(event) {
    event = (event || window.event);
    if (event.keyCode == 123) {
        return false;
    }
}

// To To Disable ctrl+c, ctrl+u

// jQuery(document).ready(function($) {
//     $(document).keydown(function(event) {
//         var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

//         if (event.ctrlKey && (pressedKey == "c" || pressedKey == "u")) {
//             //disable key press porcessing
//             return false;
//         }
//     });
// });

function getkey(e) {
    if (window.event)
        return window.event.keyCode;
    else if (e)
        return e.which;
    else
        return null;
}

function goodchars(e, goods, field) {
    var key, keychar;
    key = getkey(e);
    if (key == null) return true;

    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    goods = goods.toLowerCase();

    // check goodkeys
    if (goods.indexOf(keychar) != -1)
        return true;
    // control keys
    if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
        return true;

    if (key == 13) {
        var i;
        for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i])
                break;
        i = (i + 1) % field.form.elements.length;
        field.form.elements[i].focus();
        return false;
    };
    // else return false
    return false;
}
    </script>