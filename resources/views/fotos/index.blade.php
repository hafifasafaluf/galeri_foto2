@extends('layouts.app')

@section('title', 'Fotos')

@section('content')
<div class="box">
    <h2 class="subtitle">Daftar Foto</h2>
    <table class="table is-fullwidth is-striped" id="fotos-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal Unggah</th>
                <th>Lokasi</th>
                <th>AlbumID</th>
                <th>UserID</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="box">
    <h2 class="subtitle">Tambah / Update Foto</h2>
    <form id="foto-form">
        <input type="hidden" id="foto-id" />

        <div class="field">
            <label class="label">Judul Foto</label>
            <div class="control">
                <input class="input" id="field-judul" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Deskripsi</label>
            <div class="control">
                <textarea class="textarea" id="field-deskripsi"></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Tanggal Unggah</label>
            <div class="control">
                <input class="input" id="field-tanggal" type="date" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Lokasi File</label>
            <div class="control">
                <input class="input" id="field-lokasi" required />
            </div>
        </div>

        <div class="field">
            <label class="label">AlbumID</label>
            <div class="control">
                <input class="input" id="field-albumid" type="number" required />
            </div>
        </div>

        <div class="field">
            <label class="label">UserID</label>
            <div class="control">
                <input class="input" id="field-userid" type="number" required />
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-primary" type="submit">Simpan</button>
            </div>
            <div class="control">
                <button class="button is-light" type="button" id="reset-form">Bersihkan</button>
            </div>
        </div>
    </form>
</div>

<script>
    const apiBase = '/api/fotos';

    async function fetchFotos() {
        const res = await fetch(apiBase);
        const data = await res.json();
        const tbody = document.querySelector('#fotos-table tbody');
        tbody.innerHTML = '';

        data.forEach(f => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${f.FotoID}</td>
                <td>${f.JudulFoto}</td>
                <td>${f.DeskripsiFoto}</td>
                <td>${f.TanggalUnggah}</td>
                <td>${f.LokasiFile}</td>
                <td>${f.AlbumID}</td>
                <td>${f.UserID}</td>
                <td>
                    <button class="button is-small is-info" data-id="${f.FotoID}" data-action="edit">Edit</button>
                    <button class="button is-small is-danger" data-id="${f.FotoID}" data-action="delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function saveFoto(event) {
        event.preventDefault();
        const id = document.getElementById('foto-id').value;
        const payload = {
            JudulFoto: document.getElementById('field-judul').value,
            DeskripsiFoto: document.getElementById('field-deskripsi').value,
            TanggalUnggah: document.getElementById('field-tanggal').value,
            LokasiFile: document.getElementById('field-lokasi').value,
            AlbumID: parseInt(document.getElementById('field-albumid').value, 10),
            UserID: parseInt(document.getElementById('field-userid').value, 10),
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        resetForm();
        await fetchFotos();
    }

    async function deleteFoto(id) {
        await fetch(`${apiBase}/${id}`, { method: 'DELETE' });
        await fetchFotos();
    }

    async function editFoto(id) {
        const res = await fetch(`${apiBase}/${id}`);
        const f = await res.json();
        document.getElementById('foto-id').value = f.FotoID;
        document.getElementById('field-judul').value = f.JudulFoto;
        document.getElementById('field-deskripsi').value = f.DeskripsiFoto;
        document.getElementById('field-tanggal').value = f.TanggalUnggah;
        document.getElementById('field-lokasi').value = f.LokasiFile;
        document.getElementById('field-albumid').value = f.AlbumID;
        document.getElementById('field-userid').value = f.UserID;
    }

    function resetForm() {
        document.getElementById('foto-form').reset();
        document.getElementById('foto-id').value = '';
    }

    document.getElementById('foto-form').addEventListener('submit', saveFoto);
    document.getElementById('reset-form').addEventListener('click', resetForm);

    document.querySelector('#fotos-table').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const id = button.getAttribute('data-id');
        const action = button.getAttribute('data-action');

        if (action === 'edit') return editFoto(id);
        if (action === 'delete') return deleteFoto(id);
    });

    fetchFotos();
</script>
@endsection
