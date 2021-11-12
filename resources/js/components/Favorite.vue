<template>
  <div class="new">    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Link</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="data in news" :key="data.id">
                <td>{{data.title}}</td>
                <td><a target="_blank" :href="data.url"><i class="fas fa-link"></i></a></td>
                <td><button class="btn btn-danger" @click="deleteFavorite(data.id)"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
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
            
        axios.delete('/favorites/' + id)
        .then(response => {
            console.log(response);
            this.getFavoriteNews()
        })
        .catch(error => {
            console.log(error);
        });

    }
  }
}
</script>