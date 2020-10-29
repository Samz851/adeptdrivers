<?php
/**
 * This is the template for the test page
 */
?>
<div class="ad-test-page">
    <button type="button" id="display-key">Display Key</button>
    <div class="ad-display-key"></div>
    <button type="button" id="create-task">Create Task</button>
    <div class="ad-create-task"></div>
    <button type="button" id="get-agents">Get All Agents (Can be filtered for Fulltime/Part)</button>
    <div class="ad-get-agents"></div>
    <button type="button" id="assign-task">Assign Task (To Shan's ID)</button>
    <div class="ad-assign-task"></div>
</div>
<script>
    $ = jQuery.noConflict();

    $(document).ready(()=>{
        var disBtn = $('#display-key');
        var createBtn = $('#create-task');
        var getAgentsBtn = $('#get-agents');
        var assignTaskBtn = $('#assign-task');
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
                    $('.ad-create-task').append(`<pre>${JSON.stringify(JSON.parse(response.message), null, 2)}</pre>`);
                    console.log(response.message);
                }
            })
        })

        /**
         * Test Get Agents
         */
         getAgentsBtn.on('click', e => {
             e.preventDefault();

             var data = {
                 'action' : 'ad_get_agents'
             }

             $.post(ajaxurl, data, response => {
                 if(response){
                     $('.ad-get-agents').append(`<pre>${JSON.stringify(JSON.parse(response.message), null, 2)}</pre>`)
                     console.log(JSON.parse(response.message));
                 }
             })
         });

         /**
          * Assign Task to Agent
          */
         assignTaskBtn.on('click', e => {
             e.preventDefault();

             var data = {
                 'action' : 'ad_assign_task_to_agent'
             }

             $.post(ajaxurl, data, response => {
                if(response){
                     $('.ad-assign-task').append(`<pre>${JSON.stringify(JSON.parse(response.message), null, 2)}</pre>`)
                     console.log(JSON.parse(response.message));
                 }
             })
         })

    })
</script>