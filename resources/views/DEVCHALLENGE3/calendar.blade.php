<!DOCTYPE html>
<html>

<head>
    <title>Calendari d'Esdeveniments</title>
    @vite(['resources/css/calendar.css', 'resources/js/calendar.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-gray-300 hover:text-white">Edwin Medrano</a>
            <!-- Nombre de usuario y opción de cerrar sesión -->
            @auth
                <div class="flex items-center">
                    <span class="mr-2">{{ auth()->user()->name }}</span>
                    <a href="{{ route('logout') }}" class="text-gray-300 hover:text-white">Cerrar Sesión</a>
                </div>
            @endauth

        </div>
    </nav>
    <div id='calendar'></div>
    <!-- Modal Crear Event -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Esdeveniment</h5>
                    <button type="button" class="close" aria-label="Close" id="btnCerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('event.store') }}" method="POST" name="form" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" name="name" id="name"
                                aria-describedby="helpId" placeholder="Escriu el títol" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripció</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Color:</label><br>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-dark">
                                    <input type="radio" name="color" value="#343a40"> Personal
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="color" value="#6c757d"> Treball
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start">Data d'Inici:</label>
                            <input type="datetime-local" class="form-control" name="start" id="start"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="end">Data Final:</label>
                            <input type="datetime-local" class="form-control" name="end" id="end"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Editar i eliminar esdeveniment -->
    <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edita Esdeveniment</h5>
                    <button type="button" class="close" aria-label="Close" id="btnClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('event.update', ['id' => '__id__']) }}" method="POST" name="editForm"
                        id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="event_id">
                        <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" name="name" id="nameEdit"
                                aria-describedby="helpId" placeholder="Escriu el títol">
                        </div>

                        <div class="form-group">
                            <label for="description">Descripció</label>
                            <textarea class="form-control" name="description" id="descriptionEdit" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Color:</label><br>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-dark">
                                    <input type="radio" name="color" value="#343a40"> Personal
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="color" value="#6c757d"> Treball
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start">Data d'Inici:</label>
                            <input type="datetime-local" class="form-control" name="start" id="startEdit"
                                aria-describedby="helpId" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="end">Data Final:</label>
                            <input type="datetime-local" class="form-control" name="end" id="endEdit"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Edita</button>
                        </div>
                    </form>
                    <form action="{{ route('event.destroy', ['id' => '__id__']) }}" method="POST" name="deleteForm"
                        id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <!-- Camp ocult per emmagatzemar l'ID de l'esdeveniment -->
                        <input type="hidden" name="event_id" id="event_id" value="">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Elimina</button>
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
