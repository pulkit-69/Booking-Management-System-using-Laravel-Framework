@extends('layout.baseview')
@section('title','All Tasks')
@section('style')

    <style>
        .done{
                text-decoration: line-through;
        }
    </style>

@endsection

@section('content')
    @include('layout.nevigation')
    <div class="container mt-5">
        <button type="button" class="btn btn-outline-primary mb-5 end-0" onclick="addTask()">Add Task</button>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col">SL. no.</th>
                            <th class="col">Task Description</th>
                            <th class="col">Task Owner</th>
                            <th class="col">Task ETA</th>
                            <th class="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskTable">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- create task -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="createTaskDescription" placeholder="Enter Task Description">
                        </div>

                        <div class="form-group">
                            <label for="createTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="createTaskOwner" placeholder="Enter Task Owner">
                        </div>

                        <div class="form-group">
                            <label for="createTaskEmail">Task Owner Email</label>
                            <input type="text" class="form-control" id="createTaskEmail" placeholder="Enter Task Owner Email">
                        </div>

                        <div class="form-group">
                            <label for="createTaskETA">Task ETA</label>
                            <input type="date" class="form-control" id="createTaskETA" placeholder="Enter Task ETA">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit task-->

    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="editTaskDescription" placeholder="Enter Task Description">
                        </div>

                        <div class="form-group">
                            <label for="editTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="editTaskOwner" placeholder="Enter Task Owner">
                        </div>

                        <div class="form-group">
                            <label for="editTaskEmail">Task Owner Email</label>
                            <input type="text" class="form-control" id="editTaskEmail" placeholder="Enter Task Owner Email">
                        </div>

                        <div class="form-group">
                            <label for="editTaskETA">Task ETA</label>
                            <input type="date" class="form-control" id="editTaskETA" placeholder="Enter Task ETA">
                        </div>

                        <div class="form-group">

                            <label for="editTaskStatus">Task Status</label>

                            <select id="editTaskStatus" class="form-control">
                                <option>Set Task Status</option>
                                <option value="0">In Progress</option>
                                <option value="1">Done</option>
                               

                            </select>
                        </div>
                        <input type="hidden" id="editTaskid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Mark as task-->

    <div class="modal fade" id="doneTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark task As Done</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                            <p>Are u want to mark as done?</p>
                        <input type="hidden" id="doneTaskid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updatemarkAsDone()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete task modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this task?</p>
                <input type="hidden" id="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTaskDelete()">Submit</button>
            </div>
        </div>
    </div>
</div>





@endsection

@section('customjs')
   <script>
        $(document).ready(function () {
            getAllTasks();
        });

        function getAllTasks() {
            $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/api/task',
                success: function (result) {
                    var html = '';
                    for (var i = 0; i < result.length; i++) {
                        var lineThrough = result[i]['status'] == 1 ? 'class="done"' : '';
                    html += `<tr>
                        <th scope="row">${i + 1}</th>
                        <td ${lineThrough}>${result[i]['task_description']}</td>
                        <td ${lineThrough}>${result[i]['task_owner']}</td>
                        <td ${lineThrough}>${result[i]['task_eta']}</td>
                        <td>
                            <i class="bi bi-pencil-square" onclick="editTask(${result[i]['id']})"></i>
                            <i class="bi bi-check2-square" onclick="markAsDone(${result[i]['id']})"></i>
                            <i class="bi bi-trash" onclick="deleteTask(${result[i]['id']})"></i>
                        </td>
                    </tr>`;
                    }
                    $("#taskTable").html(html);
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
        }

        function addTask() {
            $("#createTaskModal").modal('show');
        }

        function createTask() {
            var task_description = $('#createTaskDescription').val();
            var task_owner = $('#createTaskOwner').val();
            var task_owner_email = $('#createTaskEmail').val();
            var task_eta = $('#createTaskETA').val();

            $.ajax({
                type: 'POST',
                url: 'http://localhost:8000/api/task',
                data: {
                    task_description: task_description,
                    task_owner: task_owner,
                    task_owner_email: task_owner_email, // Corrected field name
                    task_eta: task_eta
                },
                success: function (result) {
                    $("#createTaskModal").modal('hide');
                    getAllTasks();
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
        }





        function editTask(id) {
    $.ajax({
        type: 'get',
        url: 'http://localhost:8000/api/task/' + id,
        success: function (result) {
            $('#editTaskDescription').val(result['task_description']);
            $('#editTaskOwner').val(result['task_owner']);
            $('#editTaskEmail').val(result['task_owner_email']);
            $('#editTaskETA').val(result['task_eta']);
            $('#editTaskStatus').val(result['status']);

            $('#editTaskid').val(result['id']);

           
            $("#editTaskModal").modal('show');
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}


function updateTask() {
    var id = $('#editTaskid').val();
    var task_description = $('#editTaskDescription').val();
    var task_owner = $('#editTaskOwner').val();
    var task_owner_email = $('#editTaskEmail').val();
    var task_eta = $('#editTaskETA').val();
    var task_status = $('#editTaskStatus').val();

    $.ajax({
        type: 'put', // Assuming you are using PUT for updating tasks
        url: 'http://localhost:8000/api/task/' +id, // Specify the URL to update the specific task
        data: {
            task_description: task_description,
            task_owner: task_owner,
            task_owner_email: task_owner_email,
            task_eta: task_eta,
            status: task_status
        },
        success: function (result) {
            // If the update is successful, hide the edit task modal and update the task in the UI (if needed)
            $("#editTaskModal").modal('hide');
            // You can also update the task in the UI if needed, e.g., by refreshing the task list
            getAllTasks(); // Refresh the task list
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}

// marks as done

function markAsDone(id) {
    $("#doneTaskid").val(id);
    $("#doneTaskModal").modal('show');
}

function updatemarkAsDone() {
    var id = $("#doneTaskid").val();

    $.ajax({
        type: 'POST', // Use the appropriate HTTP method (POST) for marking a task as done
        url: 'http://localhost:8000/api/task/done/' + id, // Specify the URL for marking the task as done
        success: function (result) {
            // If the update is successful, hide the done task modal and update the task in the UI (if needed)
            $("#doneTaskModal").modal('hide');
            // You can also update the task in the UI if needed, e.g., by refreshing the task list
            getAllTasks(); // Refresh the task list
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}


// delete

function deleteTask(id) {
    $("#id").val(id); // Updated the input id to "id"
    $("#deleteTaskModal").modal('show');
}

function updateTaskDelete() {
    var id = $("#id").val(); // Updated the input id to "id"

    $.ajax({
        type: 'delete', // Use the DELETE HTTP method for deleting tasks
        url: 'http://localhost:8000/api/task/' + id, // Specify the URL to delete the task
        success: function (result) {
            // If the delete is successful, hide the delete task modal and update the task list in the UI (if needed)
            $("#deleteTaskModal").modal('hide');
            // You can also update the task list in the UI if needed, e.g., by refreshing the task list
            getAllTasks(); // Refresh the task list
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}









    </script> 
@endsection
