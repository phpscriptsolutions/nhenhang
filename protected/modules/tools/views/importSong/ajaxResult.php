<div class="grid-view" id="admin-song-model-grid">
<div class="title-result"><strong>Danh sách bài hát import lỗi</strong></div>
	<div class="import-result">
		<table class="items">
		<thead>
		<tr>
			<th id="admin-song-model-grid_c1"width="6%">TT</th>
			<th id="admin-song-model-grid_c2" width="35%">Name </th>
			<th id="admin-song-model-grid_c3">Đường dẫn</th>
			<th id="admin-song-model-grid_c4">TT File</th>
		</tr>
		</thead>
		<tbody class="result_row">
		<?php 
			echo '<tr class="odd">
				<td></td>
				<td>'.$notImport['name'].'</td>
				<td >
					'.$notImport['path'].'
				</td>
				<td>
					'.$notImport['stt'].'
				</td>
				</tr>';
		?>
		</tbody>
		</table>
	</div>
</div>
