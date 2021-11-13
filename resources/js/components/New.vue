<template>
  <div class="new">    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data,index) in news" :key="index">
                <td>{{index + 1}}</td>
                <td>{{data.data.title}}</td>
                <td><i @click="addFavorite(data.data)" class="far fa-star fa-lg active link-active" :class="{'fas fa-star':(active === index + 1 )}" @mouseover="setActive(index + 1)" @mouseout="setActive('')" title="Agregar a favoritos"></i></td>
            </tr>
        </tbody>
    </table>
  </div>
</template>

<script>

export default {
  name: 'New',
  data(){
    return {
      news : [],
      idsFavoriteNews: [],
      active : ''    
    }
  },
  components: {
    
  },
  created(){
    this.getIdsFavoriteNews()
    this.getNews()
  },
  methods:{

    async getIdsFavoriteNews() {
      try {
        const response = await axios.get('/favorites');            
        this.idsFavoriteNews = response.data.map(data => data.id_new)
        console.log(this.idsFavoriteNews)
      } catch (error) {
        console.error(error);
      }
    },

    async getNews() {
      try {
        const response = await axios.get('https://hacker-news.firebaseio.com/v0/newstories.json');
        let data = response.data     
        
        // Excluir noticias agregadas en favoritas
        data = data.filter(id => !this.idsFavoriteNews.includes(id) ) 

        // Mostrar las ultimas 10 noticias
        let lastNews = []
        data.slice(0,10).forEach(id => {
          axios.get('https://hacker-news.firebaseio.com/v0/item/' + id + '.json')          
            .then(resp => {
              lastNews.push(resp) 
              this.news = lastNews
            })
            .catch( err => console.log(err))
        })
       

      } catch (error) {
        console.error(error);
      }
    },

    addFavorite(data){
            
        axios.post('/favorites', {
            id: data.id,
            title: data.title,
            url: data.url
        })
        .then(response => {
            console.log(response);
            Swal.fire(
              'Correcto',
              'Noticia agregada a favoritos!',
              'success'
            )
            this.getIdsFavoriteNews()
            this.getNews()
        })
        .catch(error => {
            console.log(error);
        });

    },

    setActive(value){
      this.active = value
    }

  }
}
</script>

<style scoped>
.active{
  color: gold; 
}

.link-active:hover{
    cursor: pointer;
 }
</style>