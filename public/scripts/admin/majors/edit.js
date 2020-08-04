var deletedSkills = [];
var deletedInterests = [];
initEvent();

function initEvent() {
    var textareas = document.querySelectorAll('.skill-text');
    textareas.forEach((textarea) => {
        textarea.addEventListener('keydown', autosizeSkill);
    });

    textareas = document.querySelectorAll('.interest-text');
    textareas.forEach((textarea) => {
        textarea.addEventListener('keydown', autosizeInterest);
    });

}

function newSkill() {
    $('#skills').append(`
            <div class="row m-3">
                <div class="col-auto pr-3">A</div>
                <div class="col p-0">
                    <textarea class="skill-text form-control simple-textarea growable-textarea" rows="1"></textarea>
                </div>

                <div class="col-auto pl-3">
                    <button onclick="deleteSkill(this)">CLICK</button>
                </div>
            </div>
        `);
    initEvent();
}

function newInterest() {
    $('#interests').append(`
            <div class="row m-3">
                <div class="col-auto pr-3">A</div>
                <div class="col p-0">
                    <textarea class="interest-text form-control simple-textarea growable-textarea" rows="1"></textarea>
                </div>

                <div class="col-auto pl-3">
                    <button onclick="deleteInterest(this)">CLICK</button>
                </div>
            </div>
        `);
    initEvent();
}


function autosizeSkill(evt) {
    autosize(this, evt, newSkill)
}

function autosizeInterest(evt) {
    autosize(this, evt, newInterest)
}

function autosize(textarea, evt, callback) {
    if (evt.keyCode == 13) {
        if (!textarea.value || textarea.value === '') {
            evt.preventDefault();
            return;
        }
        callback();
        evt.preventDefault();
        return;

    }
    setTimeout(function() {
        textarea.style.cssText = 'height:auto;';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        textarea.style.cssText = 'height:' + (
            textarea.scrollHeight + 2
        ) + 'px';
    }, 0);
}


function deleteSkill(node, id) {
    deletedSkills.push(id);
    var deletedNode = node.parentNode.parentNode;
    var parent = deletedNode.parentNode;
    parent.removeChild(deletedNode);
}

function deleteInterest(node, id) {
    deletedInterests.push(id);
    var deletedNode = node.parentNode.parentNode;
    var parent = deletedNode.parentNode;
    parent.removeChild(deletedNode);
}

function saveSkills() {
    var newSkills = [];
    var oldSkills = [];

    var newInterests = [];
    var oldInterests = [];

    document.querySelectorAll('.skill-text').forEach((node) => {
        var data_id = node.getAttribute('data-id');
        if (data_id) {
            oldSkills.push({
                id: data_id,
                skill: node.value
            });
        } else {
            newSkills.push(node.value);
        }
    });
    document.querySelectorAll('.interest-text').forEach((node) => {
        var data_id = node.getAttribute('data-id');
        if (data_id) {
            oldInterests.push({
                id: data_id,
                interest: node.value
            });
        } else {
            newInterests.push(node.value);
        }
    });
    var data = {
        newSkills: newSkills,
        deletedSkills: deletedSkills,
        oldSkills: oldSkills,
        newInterests: newInterests,
        oldInterests: oldInterests,
        deletedInterests: deletedInterests
    };
    var jqxhr = $.post("/public/admin/majors/edit/IC", data, function() {
            // alert("success");
        })
        .done(function(data) {
            console.log(data);
            // alert("second success");
        })
        .fail(function(data) {
            alert("error");
        })
        .always(function() {
            alert("finished");
        });
}

function deleteArea(btn, area) {
    var jqxhr = $.get(`/public/admin/majors/areas/delete/${area}`, function() {
            // alert("success");
        })
        .done(function(data) {
            console.log(data);
            deleteInterest(btn);
            // alert("second success");
        })
        .fail(function(data) {
            console.log(data);
            alert("error");
        })
        .always(function() {
            alert("finished");
        });
}