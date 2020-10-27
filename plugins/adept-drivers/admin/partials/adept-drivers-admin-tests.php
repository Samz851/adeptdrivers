<?php
/**
 * This is the template for the test page
 */
?>
<div class="ad-test-page">
    <button type="button" id="display-key">Display Key</button>
    <div class="ad-display-key"></div>
    <button type="button" id="create-task">Create Task</button>
</div>
<script>
    $ = jQuery.noConflict();

    $(document).ready(()=>{
        var disBtn = $('#display-key');
        var createBtn = $('#create-task');
        /**
         * Test Get Tookan Key
         */
        disBtn.on('click', e => {
            e.preventDefault();

            var data = {
                'action': 'ad_get_tookan_key'
            }

            $.post(ajaxurl, data, response => {
                if(response){
                    $('.ad-display-key').text(response.message);
                }
            });
        });

        /**
        * Test Create Task
        */
        createBtn.on('click', e=> {
            e.preventDefault();

            var data = {
                'action' : 'ad_create_tookan_task'
            };

            $.post(ajaxurl, data, response => {
                if(response){
                    console.log(response.message);
                }
            })
        })

    })
</script>