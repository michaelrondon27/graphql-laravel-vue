<template>
	<div class="edit">
		<h1>Edit Book</h1>
		<form action="#" method="POST" @submit.prevent="editBook">
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" id="title" v-model="title">
			</div>
			<div class="form-group">
				<label for="author">Author</label>
				<input type="text" name="author" id="author" v-model="author">
			</div>
			<div class="form-group">
				<label for="image">Image</label>
				<input type="text" name="image" id="image" v-model="image">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="30" rows="10" v-model="description"></textarea>
			</div>
			<div class="form-group">
				<label for="link">Link</label>
				<input type="text" name="link" id="link" v-model="link">
			</div>
			<div class="form-group">
				<label for="link">
					<input type="checkbox" name="featured" id="featured" v-model="featured">Featured
				</label>
			</div>
			<div class="form-group">
				<ApolloQuery :query="require('@/graphql/queries/Categories.gql')">
					<template slot-scope="{ result: { data, loading }, isLoading }">
		        		<div v-if="isLoading">Loading...</div>
		        		<select v-else name="category" id="category" class="input-field input-normal" v-model="category">
							<option v-for="category of data.categories" :key="category.id" :value="category.id">
		            			{{ category.name }}
							</option>
		        		</select>
					</template>
				</ApolloQuery>
			</div>
			<div class="form-group">
				<button type="submit">Update book</button>
			</div>
		</form>
	</div>
</template>

<script>
	import book from '@/graphql/queries/Book.gql'
	import updateBook from '@/graphql/mutations/UpdateBook.gql'

	export default {
		data() {
			return {
				title: '',
				author: '',
				image: '',
				description: '',
				link: '',
				featured: false,
				category: 1,
				book: null
			}
		},
		apollo: {
			book: {
    			query: book,
    			variables () {
    				if (this.$route && this.$route.params) {
    					return {
        					id: this.$route.params.id,
      					}
    				}
    			},
    			result ({ data, loading, networkStatus }) {
      				this.title = data.book.title
      				this.author = data.book.author
      				this.image = data.book.image
      				this.description = data.book.description
      				this.link = data.book.link
      				this.featured = data.book.featured
      				this.category = data.book.category.id
    			},
  			},
		},
		methods: {
			editBook() {
				this.$apollo.mutate({
			    	mutation: updateBook,
			    	variables: {
			    		id: this.$route.params.id,
			        	title: this.title,
						author: this.author,
						image: this.image,
						link: this.link,
						description: this.description,
						featured: this.featured,
						category: this.category
			      	}
			    }).then((data) => {
			      	this.$router.push(`/books/${this.$route.params.id}`)
			    }).catch((error) => {
			        console.error(error)
			    })
			}
		}
	}
</script>

<style scoped>
	.form-group {
		margin-bottom: 32px;
	}
	input[type="text"] {
		padding: 10px 14px;
	}
	button {
		padding: 16px;
		background: #027BFF;
		color: white;
		border-radius: 5px;
		font-size: 16px;
	}
</style>