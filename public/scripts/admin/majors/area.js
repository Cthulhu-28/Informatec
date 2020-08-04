var deletedTasks = [];
initEvent();

function initEvent() {
    var textareas = document.querySelectorAll('.task-text');
    textareas.forEach((textarea) => {
        textarea.addEventListener('keydown', autosizeTask);
    });

    textareas = document.querySelectorAll('.area-text');
    textareas.forEach((textarea) => {
        textarea.addEventListener('keydown', autosizeArea);
    });

}

function newTask() {
    $('#tasks').append(`
            <div class="row m-3">
                <div class="col-auto pr-3">A</div>
                <div class="col p-0">
                    <textarea class="task-text form-control simple-textarea growable-textarea" rows="1" name="task[]"></textarea>
                </div>

                <div class="col-auto pl-3">
                    <button onclick="deleteTask(this)" type="button">CLICK</button>
                </div>
            </div>
        `);
    initEvent();
}

function newArea() {
    $('#areas').append(`
            <div class="row m-3">
                <div class="col-auto pr-3">A</div>
                <div class="col p-0">
                    <textarea class="area-text form-control simple-textarea growable-textarea" rows="1" name="area[]"></textarea>
                </div>

                <div class="col-auto pl-3">
                    <button onclick="deleteArea(this)" type="button">CLICK</button>
                </div>
            </div>
        `);
    initEvent();
}


function autosizeTask(evt) {
    autosize(this, evt, newTask)
}

function autosizeArea(evt) {
    autosize(this, evt, newArea)
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


function deleteTask(node) {
    var deletedNode = node.parentNode.parentNode;
    var parent = deletedNode.parentNode;
    parent.removeChild(deletedNode);
}

function deleteArea(node) {
    var deletedNode = node.parentNode.parentNode;
    var parent = deletedNode.parentNode;
    parent.removeChild(deletedNode);
}