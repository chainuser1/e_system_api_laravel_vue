<template>
  <div class="">
    <!-- create a profile page of student using bootstrap -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3>Student Profile</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar" class="img-responsive">
                </div>
                <div class="col-md-9 personal-info">
                  <div class="row">
                    <div class="col-md-3">
                      <h3>{{student.last_name}}, {{student.first_name}} {{student.middle_name}} {{student.suffix}}</h3>
                    </div>
                    <div class="col-md-9">
                      <span class="badge badge-danger">{{student.class}}</span>
                      <span class="badge badge-danger">{{student.section}}</span>
                      <!-- <span class="badge badge-secondary">{{student.roll_no}}</span> -->
                      <!-- course or learning major -->
                      <span class="badge badge-warning">{{student.course}}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label class="label-control">Email</label>
                      

  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>