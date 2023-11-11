<template>
    <div class="ml-[30%] mt-[80px]">   
    <select v-model="selectedOption" @change="filterComments()">
      <option :value="['comments.username', 'ASC']">Filter by username ↑</option>
      <option :value="['comments.username', 'DESC']">Filter by username ↓</option>
      <option :value="['accounts.email', 'ASC']">Filter by email</option>
      <option :value="['comments.created_at', 'ASC']">Filter by date ↑</option>
      <option :value="['comments.created_at', 'DESC']" selected>Filter by date ↓</option>
    </select>
        <ul>
            <li v-for="comment in comments" :key="comment.id" class="mt-[20px]">
             <CommentComponent
              @getComments="getComments"
              @getCapcha="getCapcha"
              @updateShowCommentForm="updateShowCommentForm"
              :comment="comment"
              :user="user"
              :hasResponses ="hasResponses[comment.id]"
              v-model:showCommentForm.sync="showCommentForm"
              v-model:answerId="answerId">
              </CommentComponent>
            </li>
        </ul>

        <button v-if="!showCommentForm" @click="showCommentForm = !showCommentForm, answerId=null, getCapcha()" class="mt-[40px]">Leave a comment</button>
    </div>
    <div>
       <CommentFormComponent 
        v-if="showCommentForm" 
        v-model:showCommentForm="showCommentForm" 
        @getComments="getComments"
        :user="user" 
        :session="session"
        :answerId="answerId"
        :capcha="capcha">
      </CommentFormComponent>
    </div>
    <div class="ml-[45%] mb-[20px] mt-[50px]">
    <button v-if="prev_page != null" @click="getCommentsFromNeededPage(prev_page)" class="inline-flex items-center justify-center w-full px-6 py-3 mb-2  text-white bg-green-500 rounded-md hover:bg-green-400 sm:w-auto sm:mb-0" data-primary="green-400" data-rounded="rounded-2xl">Previous Page</button>
    <button v-if="next_page != null" @click="getCommentsFromNeededPage(next_page)" class="ml-[20px] inline-flex items-center justify-center w-full px-6 py-3 mb-2  text-white bg-green-500 rounded-md hover:bg-green-400 sm:w-auto sm:mb-0" data-primary="green-400" data-rounded="rounded-2xl">Next Page</button>
    </div>
</template>

<script>
import axios from 'axios';
import CommentComponent from './CommentComponent.vue';
import CommentFormComponent from './CommentFormComponent.vue'

export default {

  components: {
    CommentFormComponent, CommentComponent
  },

  data() {
    return {
      comments: [],
      next_page: null,
      prev_page: null,
      first_page: null,
      last_page:null,
      responseComments: [],
      //commentData: {},
      showCommentForm: false,
      answerId: null,
      capcha: null,
      selectedOption: [],
      hasResponses: []
    };
  },

  props:{
    user: String,
    session: Boolean
  },

  mounted() {
    this.getComments();
  },

  methods: {
    getComments(){
        axios
            .get('http://localhost/CommentHub/public/api/comments')
            .then(response => {this.comments = response.data.comments.data;
            console.log(response.data.hasResponses);
            this.hasResponses = response.data.hasResponses;

              this.prev_page = response.data.comments.prev_page_url

              this.next_page = response.data.comments.next_page_url;
            })
            .catch(error => {
            if (error.response && error.response.data && error.response.data.message) {
              alert('Error: ' + error.response.data.message);
            } else {
              alert('An unknown error occurred');
            }
        });
    },

    updateShowCommentForm() {
      this.showCommentForm = !showCommentForm;
    },

    getCapcha(){
      axios
          .get('http://localhost/CommentHub/public/api/capcha')
          .then(response => {this.capcha = response.data.capcha;})
          .catch(error => {
            alert('Error:', error);
          });
    },

    getCommentsFromNeededPage(url){
        axios
            .get(url)
            .then(response => {this.comments = response.data.comments.data;
           
              this.hasResponses = response.data.hasResponses;

              this.prev_page = response.data.comments.prev_page_url

              this.next_page = response.data.comments.next_page_url;
            })
            .catch(error => {
            alert('Error:', error);
        });
    },

    filterComments()
    {
      const column = this.selectedOption[0];
      const type = this.selectedOption[1];
        axios
            .get(`http://localhost/CommentHub/public/api/comments/filter?column=${this.selectedOption[0]}&type=${this.selectedOption[1]}`)
            .then(response => {this.comments = response.data.comments.data;})
            .catch(error => {
            if (error.response && error.response.data && error.response.data.message) {
              alert('Error: ' + error.response.data.message);
            } else {
              alert('An unknown error occurred');
            }
        });

    },

    showResponses(commentId){
        axios
            .get('http://localhost/CommentHub/public/api/'+commentId+'/responses')
            .then(response => {this.comments = response.data.comments;
              this.responses = response.data.responses;
              })
            .catch(error => {
            alert('Error:', error);
        });
    },
    
  },
};
</script>