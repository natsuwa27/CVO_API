<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Veterinaria del Oriente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        :root {
            --primary-color: #007bff; /* Azul vibrante */
            --admin-color: #3f98ff; /* Azul medio para admin */
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --bg-light: #f4f9ff;
        }

        body { 
            background: var(--bg-light); 
            font-family: 'Poppins', sans-serif; 
            padding-top: 130px; /* Ajuste para el encabezado grande */
        }

        /* Encabezado Fijo */
        .navbar-fixed { 
            width: 100%;
            height: 110px; /* Un poco más alto */
            background-color: var(--admin-color);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1055;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Sombra más fuerte */
            border-radius: 0 0 20px 20px; /* Borde inferior más pronunciado */
        }
        .navbar-fixed a { 
            color: white; 
            font-weight: 500; 
            margin-right: 25px; 
            text-decoration: none; 
            font-size: 1.1rem;
            transition: color 0.3s;
        }
        .navbar-fixed a:hover { 
            color: var(--warning-color); /* Amarillo al pasar el ratón */
            text-decoration: none; 
        }
        .navbar-fixed .logo-text {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
        }

        /* Contenedor de la Tabla */
        .table-container { 
            background: var(--card-bg, white); 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Sombra más moderna */
        }

        /* Estilos de Botones */
        .btn-success { background-color: var(--success-color) !important; border-color: var(--success-color) !important; }
        .btn-info { background-color: var(--info-color) !important; border-color: var(--info-color) !important; }
        .btn-warning { background-color: var(--warning-color) !important; border-color: var(--warning-color) !important; color: #333 !important; }
        .btn-primary { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            margin: 2px;
            font-size: 0.8rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        /* Estilo de la Tabla */
        .table thead th {
            background-color: #e9ecef; /* Fondo claro para la cabecera */
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Modal */
        .modal-header-custom {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .modal-content {
            border-radius: 15px;
        }
        .modal-title {
            font-weight: 600;
        }
        .form-group label {
            font-weight: 500;
            color: #555;
        }

        .modal {
    z-index: 9999 !important; /* el modal encima de todo */
}

.modal-backdrop {
    z-index: 9998 !important; /* fondo oscurecido justo debajo */
}

    </style>
</head>

<body>

<div class="navbar-fixed">
    <div class="d-flex align-items-center">
        <img src="{{ asset('css/logo.jpg') }}" alt="Logo" style="height:60px; border-radius: 50%; margin-right: 15px;">
        <span class="logo-text">Panel Admin</span>
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.homeadmin') }}"><i class="fas fa-home mr-1"></i> Inicio</a>
        <a href="#"><i class="fas fa-users-cog mr-1"></i> Usuarios</a>
        <a href="#"><i class="fas fa-chart-bar mr-1"></i> Reportes</a>
        <a href="#"><i class="fas fa-user-circle mr-1"></i> Perfil</a>

        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left: 20px;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="font-weight-bold mb-4 text-dark">Bienvenido, {{ Auth::user()->name }}</h2>

    <div class="table-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold text-primary"><i class="fas fa-table mr-2"></i> Gestión de Usuarios</h4>

            <button type="button" class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#crearUsuarioModal">
                <i class="fas fa-plus-circle"></i> Crear Nuevo Usuario
            </button>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($usuarios as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->description ?? 'Sin rol' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->address ?? '-' }}</td>
                        <td>
                            @if($user->active)
                                <span class="badge badge-success">Sí</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </td>

                        <td>
                            @if($user->id !== Auth::id())

                                <button 
                                    class="btn btn-info btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#editarUsuarioModal{{ $user->id }}"
                                    title="Editar Usuario">
                                    <i class="fas fa-edit"></i>
                                </button>

                                @if($user->active)
                                    <form action="{{ route('admin.desactivar', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm" title="Desactivar">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.reactivar', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" title="Reactivar">
                                            <i class="fas fa-unlock"></i>
                                        </button>
                                    </form>
                                @endif

                            @else
                                <span class="text-muted small">Tú</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="crearUsuarioModal" tabindex="-1">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">

      <div class="modal-header modal-header-custom">
        <h5 class="modal-title"><i class="fas fa-user-plus mr-2"></i> Crear Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal"><span class="text-white">&times;</span></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('admin.storeusuario') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Rol</label>
                    <select name="role_id" class="form-control" required>
                      @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->description }}</option>
                      @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="address" class="form-control">
                </div>
            </div>
          </div>

          <div class="mt-3 text-right">
            <button type="submit" class="btn btn-success font-weight-bold">
                <i class="fas fa-check-circle"></i> Confirmar Creación
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


@foreach($usuarios as $user)
<div class="modal fade" id="editarUsuarioModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header modal-header-custom">
        <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i> Actualizar Usuario: {{ $user->name }}</h5>
        <button type="button" class="close" data-dismiss="modal"><span class="text-white">&times;</span></button>
      </div>

      <div class="modal-body">

        <form action="{{ route('admin.updateusuario', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label>Rol</label>
                        <select name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                    </div>

                    <div class="form-group">
                        <label>Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar vacío para no cambiar">
                    </div>
                </div>
            </div>

            <div class="mt-3 text-right">
                <button type="submit" class="btn btn-info font-weight-bold">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>

      </div>

    </div>
  </div>
</div>
@endforeach


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

