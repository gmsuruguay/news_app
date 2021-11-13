<template>
  <div class="new">    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre</th>                
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="data in news" :key="data.id">
                <td>{{data.title}}</td>
                <td><a target="_blank" :href="data.url"><i class="fas fa-link fa-lg" title="Ver noticia"></i></a>
                <i @click="deleteFavorite(data.id)" class="fas fa-trash-alt text-danger link-active fa-lg" title="Eliminar"></i></td>
            </tr>
        </tbody>
    </table>
  </div>
</template>

<script>

export default {
  name: 'Favorite',
  data(){
    return {
      news : []
    }
  },
  components: {
    
  },
  created(){
    this.getFavoriteNews()
  },
  methods:{

    async getFavoriteNews() {
      try {
        const response = await axios.get('/favorites');
        console.log(response)          
        this.news = response.data
      } catch (error) {
        console.error(error);
      }
    },

    deleteFavorite(id){
        Swal.fire({
          title: 'Esta seguro eliminar esta noticia?',         
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: `No`,
        }).then((result) => {
          
          if (result.isConfirmed) {
            axios.delete('/favorites/' + id)
            .then(response => {
                console.log(response);
                Swal.fire('Noticia eliminada!', '', 'success')
                this.getFavoriteNews()
            })
            .catch(error => {
                console.log(error);
            }); 

           
          } 
        })       

    }
  }
}
</script>

<style scoped>
.link-active:hover{
    cursor: pointer;
 }
</style>