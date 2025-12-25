@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Obat</h4>
    <div>
        <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">Tambah Obat</a>
    </div>
 </div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="table-responsive">
    <table class="table table-striped">
        <thead><tr><th>Nama Obat</th><th>Harga</th><th>Stok</th><th style="width:200px">Aksi</th></tr></thead>
        <tbody>
        <?php if($items->count() === 0){ ?>
            <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
        <?php } else { foreach($items as $obat){ ?>
            <tr>
                <td><?php echo e($obat->nama_obat); ?></td>
                <td>Rp<?php echo e(number_format($obat->harga,0,',','.')); ?></td>
                <td>
                    <?php $stok = (int)($obat->stok ?? 0); ?>
                    <span class="badge <?php echo $stok === 0 ? 'bg-danger' : ($stok <= 5 ? 'bg-warning text-dark' : 'bg-success'); ?>">
                        <?php echo e($stok); ?>
                        <?php if($stok === 0){ ?> (Habis) <?php } elseif($stok <= 5){ ?> (Menipis) <?php } ?>
                    </span>
                </td>
                <td>
                    <a class="btn btn-sm btn-warning" href="<?php echo e(route('admin.obat.edit', $obat)); ?>">Edit</a>
                    <form action="<?php echo e(route('admin.obat.destroy', $obat)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus obat?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>
</div>
{{ $items->links() }}
@endsection
