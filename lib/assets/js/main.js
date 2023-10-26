document.addEventListener('DOMContentLoaded', function() {
    
    // slug restriction
    var textField = document.getElementById('slug');
    if(textField) {
        textField.addEventListener('input', function() {
            var currentValue = textField.value;
            if(currentValue.length > 0){
                var lastChar = currentValue[currentValue.length - 1];
                var modifiedValue = currentValue;
                
                if (!lastChar.match(/[a-zA-Z0-9]/)) {
                modifiedValue = currentValue.slice(0, -1) + '_';
                }
                textField.value = modifiedValue;
            }
        });
    }

    var mcpt_del_btn = document.querySelectorAll('.mcpt-delete-btn');
    if(mcpt_del_btn) {
        mcpt_del_btn.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var parentForm = event.target.parentNode;
                if (parentForm) {
                    var confirmed = confirm('Are you sure you want to delete this post type?');
                    if (confirmed) {
                        parentForm.submit();
                    }
                }
            });
        });
    }

});