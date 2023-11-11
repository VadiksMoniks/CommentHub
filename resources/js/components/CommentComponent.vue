<template>
            <div>
              <div class="w-[60%] h-auto ">
                <div class="bg-blue-100 p-2 rounded-lg flex">
                  <div class="w-10 h-10 rounded-full overflow-hidden"><img :src="'../avatars/' + comment.avatar"/></div>
                  <b class="ml-8">{{ comment.username }}</b>
                  <p class="ml-8">{{ comment.created_at }}</p>
                  <button @click="deleteComment(comment.id);" v-if="this.user == comment.username" class="ml-[55%]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                  </button>
                </div>
                <div class="p-4 ">
                  <div class="pr-4 overflow-hidden" style="white-space: pre-wrap; word-wrap: break-word;" v-html="comment.text">
                  </div>
                  <div v-if="comment.document != null" class="ml-4 mt-4">
                    <i>{{ comment.document }}</i>
                  </div>
                  <div v-if="comment.image != null" >
                    <img :src="'../storage/app/' + comment.image" class="max-w-48 max-h-48">
                  </div>
                </div>
                <div>
                  <button v-if="hasResponses !== 0" @click="loadResponses(comment.id)">Load responses</button><br>
                  <button @click="$emit('update:answerId' ,comment.id); this.$emit('update:showCommentForm', !this.showCommentForm); this.$emit('getCapcha')" class="text-blue-400 hover:text-blue-500">Answer for comment</button>
                </div>               
              </div>
              <div v-if="responses != []" class="ml-[5%] w-[90%]">
                <ul>
                  <li v-for="response in responses" :key="response.id" class="mt-[20px]">
                    <CommentComponent
                    @getComments="getComments"
                    @getCapcha="getCapcha"
                    :comment="response"
                    :user="user"
                    :hasResponses ="has_Responses[response.id]"
                    :showCommentForm="showCommentForm"
                    :answerId="answerId"
                    >
                    </CommentComponent>
                  </li> 
                </ul>
              </div>
            </div>
</template>

<script>
import axios from 'axios';
export default {

    data(){
        return{
          responses: [],
          has_Responses: [],
          showCommentForm1: this.showCommentForm
        }
    },

    props:{
        comment: Object,
        user: String,
        showCommentForm: Boolean,
        answerId: Number,
        hasResponses: Number,
        capcha: String,
        getComments: Function,
        getCapcha: Function,
        updateShowCommentForm: Function

    },

    methods:{
        deleteComment(commentId){
            axios
            .delete('http://localhost/CommentHub/public/api/'+commentId+'/delete')
            .then( response => {
                if(response.status == 200){
                    alert(response.data.message);
                    this.$emit('getComments');
                }
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    alert('Something went wrong: '+error.response.data.message);
                } 
            });
        },

        loadResponses(commentId){
          axios
            .get('http://localhost/CommentHub/public/api/comments/' + commentId + '/responses')
            .then(response => {this.responses = response.data.responses;
            this.has_Responses = response.data.hasResponses;
            })
            .catch(error => {
            if (error.response && error.response.data && error.response.data.message) {
              alert('Error: ' + error.response.data.message);
            } else {
              alert('An unknown error occurred');
            }
          });
        },

        emitUpdate() {
          this.$emit('update:showCommentForm', !this.showCommentForm);
        
        },
  }
}
</script>