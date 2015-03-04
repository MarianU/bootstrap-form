				<div class="panel panel-default">
					<div class="panel-heading">Guests</div>
						<div class="panel-body">
							<p>Our honorable guests.</p>
						</div>

						<table class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Date</th>
									<th>Email</th>
									<th>Message</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($this->records as $record) : ?>
								<tr>
									<td><?php echo $record->name?></td>
									<td><?php echo $record->date?></td>
									<td class="email-encoded"><?php echo base64_encode($record->email)?></td>
									<td><?php echo $record->message?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
				</div>
			</div>
		</div>
