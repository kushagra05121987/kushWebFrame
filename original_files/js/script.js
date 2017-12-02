(function($){
    $(document).ready(function() {
        window.validateForm = function () {
            console.log("%c Dumping Debug info ", "background: #222; color: #bada55 ");
            var validationCheck = true;
            $('form#loginForm input').each(function() {
                if($(this).attr('name') != "sbmt") {
                    var elem = $(this)[0];
                    // wont work with $ jquery selectors
                    // console.log($("input[type='text']").validity);
                    // elem.setCustomValidity("custom validation message");
                    // console.log(elem.checkValidity());
                    // console.log(elem.validity);
                    // console.log(elem.validationMessage);
                    // console.log(elem.willValidate);
                    // document.forms[0].submit = true;
                    // var form = document.getElementsByTagName('form');
                    // form = form[0];
                    // form.submit();
                    if(!elem.checkValidity() || !elem.validity.valid) {
                        validationCheck = false;
                        return 0;
                    }
                }
            });
            if(validationCheck) {
                $("form#loginForm").submit()
            }
        }
        // hide temporary session related error
        setTimeout(function() {
            if(jQuery(".session-error").length) {
                jQuery(".session-error").fadeOut(500);
            }
            if(jQuery(".session-success").length) {
                jQuery(".session-success").fadeOut(500);
            }
        }, 1000);
    });
})(jQuery);