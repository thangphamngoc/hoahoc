<template>
  <div>
    <!-- Fetching users... -->
    <p> Welcome {{name}} comeback ! </p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
	data() {
    return {
    	name:"",
    }
		},

  mounted () {
    axios.get('/api/user')
    .then((resp) => {
    	console.log(resp.data);
    	this.name = resp.data.name;
    	       //      this.$message({
            //   // message: resp.data.message,
            //   // message:"",
            //   // type: "success",
            // });
          })
          .catch((err) => {
            this.$message({
              message:"Lỗi thông tin tài khoản",
              type: "error",
            });
          });
                    // .finally(() => {
          //   setTimeout(() => {
          //   }, 500);
          // });


  
	}
}
</script>
