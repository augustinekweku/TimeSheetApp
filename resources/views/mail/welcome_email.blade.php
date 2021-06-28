<div class="mail_page">
<div class="mail_card">
<h1 style="text-align: center">TimeSheet App</h1>
<h3>Welcome {{$mail_data->firstName}}</h3>
<p>Below is your Login Credentials</p>
<p>Staff ID:  {{$mail_data->staff_id}}</p>
</div>
</div>

<style>
.mail_page{
    display: flex;
    align-items: center;
    justify-content: center;
}
.mail_card {
width: 230px;
border: 1px solid black;
}
</style>