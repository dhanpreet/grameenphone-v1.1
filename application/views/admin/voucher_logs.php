        
        <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Voucher Log</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <?php foreach($logs as $row) { ?>
                        <div class="col-md-6">
                            <?php if($row['log_voucher_status']==0){ ?>
                               <b>Created At : </b>
                            <?php } else if($row['log_voucher_status']==1)
                            {
                            ?>
                                <b>Tournament :</b>
                                <br>
                                <b>Assigned to tournament :</b>  
                            <?php } else if($row['log_voucher_status']==2)
                            {
                            ?>
                                <b>User Name :</b>
                                <br>
                                <b>Assigned to user :</b>
                            <?php } else if($row['log_voucher_status']==3)
                            {
                            ?>
                                <b>Claimed by user :</b>
                            <?php } else if($row['log_voucher_status']==4)
                            {
                            ?>
                                <b>Recreated :</b>
                            <?php } else if($row['log_voucher_status']==5)
                            {
                            ?>
                                <b>Expired :</b>
                            <?php } else if($row['log_voucher_status']==6)
                            {
                            ?>
                                <b>Reissued :</b>
                            <?php } else if($row['log_voucher_status']==7)
                            {
                            ?>
                                <b>Deactivated : </b>
                            <?php } else if($row['log_voucher_status']==8)
                            {
                            ?>
                                <b>Reissueed after tournament update</b>
                            <?php } else if($row['log_voucher_status']==9)
                            {
                            ?>
                                <b>Recreated after User did not claimed :</b>
                            <?php } else {
                            ?>
                                <b>Assignment period over :</b>
                            <?php
                            } ?>
                        </div>
                        <div class="col-md-6">
                        <?php if($row['log_voucher_status']==0){ ?>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==1)
                            {
                            ?>
                                <b>
                                   <?php echo $row['tournament_name']; ?>
                               </b>
                               <br>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                               
                               
                            <?php } else if($row['log_voucher_status']==2)
                            {
                            ?>
                                <b><?php echo $row['user_full_name']; ?></b>
                                <br>
                                <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==3)
                            {
                            ?>
                                <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==4)
                            {
                            ?>
                                <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==5)
                            {
                            ?>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==6)
                            {
                            ?>
                              <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==7)
                            {
                            ?>
                              <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==8)
                            {
                            ?>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else if($row['log_voucher_status']==9)
                            {
                            ?>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php } else {
                            ?>
                               <b><?php echo date("d M Y H:i:s" , $row['log_added_on']); ?></b>
                            <?php
                            } ?>
                    </div>
                    <?php } ?>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			</div>
		</div>