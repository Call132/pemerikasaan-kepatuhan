
<form action="{{ route('user.destroy' , $data->id) }}" method="POST">
	@csrf
	@method('DELETE')
	<div class="modal fade" style="z-index: 999" id="deleteModal{{ $data->id }}" data-bs-keyboard="false"
		tabindex="-1" aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel{{ $data->id }}">Hapus Data {{ $data->name }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<span class="text-danger">Data yang telah dihapus, tidak dapat dikembalikan.</span>
					<span class="fw-bold">Apakah Anda yakin ingin menghapus data ini?</span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</div>
		</div>
	</div>
</form>