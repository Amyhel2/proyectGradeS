
<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>
<h2>Reporte de Usuarios Activos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Email</th>
                <th>Rango</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['id']; ?></td>
                <td><?= $usuario['user']; ?></td>
                <td><?= $usuario['nombres']; ?></td>
                <td><?= $usuario['apellido_paterno']; ?></td>
                <td><?= $usuario['email']; ?></td>
                <td><?= $usuario['rango']; ?></td>
                <td><?= $usuario['activo'] ? 'Activo' : 'Inactivo'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


<?= $this->endSection(); ?>