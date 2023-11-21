<script setup>
import { onMounted, computed, ref } from 'vue'
import { useFlash } from "@/composables/useFlash"

let { flash } = useFlash()

const products = ref([])

let cart = ref([])

onMounted(() => {
  fetch('http://18.234.82.38:8000/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        query {
          products {
            data {
              id
              name
              description
              price
              user {
                id
                name
                email
              }
            }
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(result => {
    products.value = result.data.products.data
  })
})

let addToCart = (product) => {
  cart.value.push({
    product_id: product.id,
    user_id: product.user.id,
    user_email: product.user.email,
    product_name: product.name,
    product_description: product.description,
    product_price: product.price
  })

  cart.value = [...new Map(cart.value.map(item => [item['product_id'], item])).values()]
}

let removeFromCart = (product_id) => {
  cart.value = cart.value.filter(item => item.product_id != product_id)
}

let checkout = (product_id, user_id, user_email, product_name, product_description, product_price) => {
  fetch('http://18.234.82.38:8002/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        mutation {
          createCheckout(user_id: "${user_id}", product_id: "${product_id}") {
            id
            product_id
            user_id
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(result => {
    console.log(result)
  })
  fetch('http://18.234.82.38:8004/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        mutation {
          createEmail(
            user_id: "${user_id}",
            product_id: "${product_id}",
            details: "${product_description}",
            price: "${product_price}",
            user_email: "${user_email}",
            product_name: "${product_name}"
          ) {
            id
            user_id
            product_id
            details
            price
            created_at
            updated_at
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(() => {
    flash('Order is placed')
  })
}
</script>

<template>
  <main>
    <div class="flex flex-row bg-gray-700">
      <ul class="bg-gray-800 rounded-lg p-3 m-4 w-3/4 grid gap-y-4">
        <li class="bg-gray-900 p-4 rounded-lg border-none text-white flex flex-row justify-between gap-4" v-for="product in products" :key="product.id">
          <div class="grid gap-y-6">
            <h3 class="text-xl">Product: {{ product.name }}</h3>
            <h4 class="text-sm">{{ product.description }}</h4>
            <div class="flex flex-row">
              <strong>Price</strong><p class="ml-3">{{ product.price }}</p>
            </div>
          </div>
          <div>
            <!-- <button class="px-3 py-2 btn bg-green-900 rounded-lg w-32 hover:bg-green-800" @click="checkout(product.id, product.user.id, product.user.email, product.name, product.description, product.price)">Checkout</button> -->
            <button class="px-3 py-2 btn bg-green-900 rounded-lg w-32 hover:bg-green-800" @click="addToCart(product)">Checkout</button>
          </div>
        </li>
      </ul>
      <div class="bg-gray-800 my-4 mr-4 rounded-lg w-1/4">
        <div class="flex flex-row justify-between">
          <h1 class="text-gray-100 text-2xl p-4 align-middle">Cart</h1>
          <button class="text-white text-md px-3 py-2 m-4 bg-green-900 rounded-lg" @click="checkout(cart)">Place order</button>
        </div>

        <ul class="bg-gray-800 rounded-lg mx-4 grid gap-y-4">
          <li class="bg-gray-900 p-4 rounded-lg border-none text-white flex flex-row justify-between gap-4" v-for="item in cart" :key="item.product_id">
            <div class="flex flex-col">
              <h3 class="text-xl">{{ item.product_name }}</h3>
              <p class="text-xs pt-2">{{ item.product_description }}</p>
              <p class="text-md pt-3">Price: {{ item.product_price }}</p>
            </div>
            <div class="grid content-end">
              <button class="btn bg-red-900 py-1 px-2 rounded-lg text-md" @click="removeFromCart(item.product_id)">Remove</button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </main>
</template>
