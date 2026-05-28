<!DOCTYPE html>
<html>
<body>

<h1>{{ $cv->nama_lengkap }}</h1>
<p>{{ $cv->email }}</p>

<hr>

<h3>Summary</h3>
<p>{{ $cv->summary }}</p>

<h3>Job Title</h3>
<p>{{ $cv->job_title }}</p>

<h3>Target Role</h3>
<p>{{ $cv->target_role }}</p>

<h3>Skills</h3>
<p>{{ $cv->skills }}</p>

</body>
</html>