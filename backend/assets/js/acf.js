/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $('#acf_group_id').change(function(){
        $('#acf_container').data('groupid', $(this).val());
        loadFieldsInAcfContainer();
    });
    
    loadFieldsInAcfContainer();
});

function loadFieldsInAcfContainer() {
    const container = $('#acf_container');
    
    const srcId   = +container.data('srcid');
    const srcType = +container.data('srctype');
    const groupId = +container.data('groupid');
    
    
    $.ajax({
        url: ACF_URL,
        type: "GET",
        data: {srcId, srcType, groupId},
        success: (response) => {
            container.html(response);
        }
    });
}

