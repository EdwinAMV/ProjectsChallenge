<x-app-layout>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Calendar of Events</title>
        @vite(['resources/css/calendar.css', 'resources/js/calendar.js'])
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body>
        <div id="calendar-container">
            <div id="calendar"></div>
        </div>
        <!-- Modal Crear Event -->
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Event</h5>
                        <button type="button" class="close" aria-label="Close" id="btnCerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('event.store') }}" method="POST" name="form" id="form">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Write the title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="color">Color Tag:</label>
                                <input type="color" class="form-control" name="color" id="color" value="#343a40">
                            </div>
                            <div class="form-group">
                                <label for="start">Initial date:</label>
                                <input type="datetime-local" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="end">Final Date:</label>
                                <input type="datetime-local" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Done</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Editar i eliminar esdeveniment -->
        <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Event</h5>
                        <button type="button" class="close" aria-label="Close" id="btnClose">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('event.update', ['id' => '__id__']) }}" method="POST" name="editForm" id="editForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="event_id">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="nameEdit" aria-describedby="helpId" placeholder="Write the title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" name="description" id="descriptionEdit" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="color">Color Tag:</label>
                                <input type="color" class="form-control" name="color" id="colorEdit">
                            </div>
                            <div class="form-group">
                                <label for="start">Initial date:</label>
                                <input type="datetime-local" class="form-control" name="start" id="startEdit" aria-describedby="helpId" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="end">Final Date:</label>
                                <input type="datetime-local" class="form-control" name="end" id="endEdit" aria-describedby="helpId" placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                        <form action="{{ route('event.destroy', ['id' => '__id__']) }}" method="POST" name="deleteForm" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <!-- Camp ocult per emmagatzemar l'ID de l'esdeveniment -->
                            <input type="hidden" name="event_id" id="event_id" value="">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var events = @json($events); // Convertir els esdeveniments a JSON
        </script>
    </body>

    </html>
</x-app-layout>
