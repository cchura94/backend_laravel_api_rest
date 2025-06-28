<div class="container">
        <h1>Listado de Notas de Compras y Ventas</h1>

        <!-- Tabla de Notas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Fecha Emisión</th>
                    <th>Tipo de Nota</th>
                    <th>Entidad Comercial</th>
                    <th>Subtotal</th>
                    <th>Impuestos</th>
                    <th>Descuento</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notas as $nota)
                    <tr>
                        <td>{{ $nota['codigo_nota'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($nota['fecha_emision'])->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($nota['tipo_nota']) }}</td>
                        <td>{{ $nota['entidad_comercial']['razon_social'] }}</td>
                        <td>${{ number_format($nota['subtotal'], 2) }}</td>
                        <td>${{ number_format($nota['impuestos'], 2) }}</td>
                        <td>${{ number_format($nota['descuento'], 2) }}</td>
                        <td>{{ $nota['user']['name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>