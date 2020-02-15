<h1>Send SMS</h1>

<form method="post" action="<?php echo base_url().'index.php/Sendsms/sendMySms'; ?>">
<label>Phone No</label>
<input type="text" placeholder="Mobile Number" required="required" name="mobile"><br><br>
<label>Message</label>
<textarea name="message" placeholder="Your Message" required="required"></textarea><br><br>
<input type="submit" name="send" value="send">
</form>