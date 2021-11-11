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
            <tr v-for="data in news" :key="data.data.id">
                <td>{{data.data.title}}</td>
                <td><button class="btn btn-primary" @click="addFavorite(data.data)">Favorito</button></td>
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
      news : []
    }
  },
  components: {
    
  },
  created(){
    this.getNews()
  },
  methods:{

    async getNews() {
      try {
        const response = await axios.get('https://hacker-news.firebaseio.com/v0/newstories.json');
        let data = response.data        
        data.slice(0,10).forEach(id => {
          axios.get('https://hacker-news.firebaseio.com/v0/item/' + id + '.json')
          .then(resp => this.news.push(resp) )
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
        })
        .catch(error => {
            console.log(error);
        });

    }
  }
}
</script>