<template>
  <div class="container mx-auto px-4 bg-gray-700 shadow-lg rounded-md mt-5 border border-gray-200 text-white">
    <div class="p-8 text-center flex justify-center items-center">
      <transition name="fade">
        <p>{{ quote }}</p>
      </transition>
      <button class="refresh-btn" @click="fetchQuote">
        <i class="fas fa-sync-alt"></i>
      </button>
    </div>

    <div class="flex flex-col items-center justify-center">
      <img :src="got" alt="Logo" class="h-100 w-19 mt-2">
      <h2 class="text-center mt-5 text-6xl font-semibold task-text">To Do List</h2>
    </div>

    <div class="flex mt-5" style="font-family: cursive;">
      <input
        type="text"
        v-model="task"
        placeholder="Enter task"
        class="w-full py-2 px-4 border rounded-md mr-2 focus:outline-none focus:ring focus:border-blue-300 bg-gray-800 text-white "
      />
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 "
        @click="submitTask"
      >
        SUBMIT
      </button>
    </div>
    
    <div class="p-8">
      <table class="w-full">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b" style="font-family: cursive;">Task</th>
            <th class="py-2 px-4 border-b" style="font-family: cursive;">Status</th>
            <th class="py-2 px-4 border-b" style="font-family: cursive;">Delete</th>
            <th class="py-2 px-4 border-b" style="font-family: cursive;">Change Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(task, index) in tasks" :key="index">
            <td class="py-2 px-4 border-b" style="font-family: cursive;">
              <span :class="{ 'line-through': task.status === 'finished' }">
                {{ task.task }}
              </span>
            </td>
            <td class="py-2 px-4 border-b" v-if="task">
  <span
    :class="{
      'text-red-500': task.status === 'to-do',
      'text-green-500': task.status === 'finished',
      'text-yellow-500': task.status === 'in-progress',
    }"
  >
    {{ capitalizeFirstChar(task.status) }}
  </span>
</td>

            <td class="py-2 px-4 border-b">
              <button @click="confirmDelete(task.id)">
                <i class="fas fa-trash-alt text-red-500"></i>
              </button>
            </td>
            <td class="py-2 px-4 border-b">
              <button @click="toggleTaskStatus(task)">
                <i :class="{'text-red-500': task.status === '0', 'text-green-500': task.status === '1'}" class="fas fa-exchange-alt"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: "todo",
  data() {
    return {
      got: "/images/got.png",
      quote: "",
      task: "",
      tasks: []
    };
  },
  mounted() {
    this.fetchTasks();
    this.fetchQuote();
  },
  methods: {
    capitalizeFirstChar(str) {
      if (str === "1") {
        return "Ongoing";
      } else if (str === "0") {
        return "Completed";
      } else {
        return str.charAt(0).toUpperCase() + str.slice(1);
      }
    },
    fetchQuote() {
      axios.get("https://api.gameofthronesquotes.xyz/v1/random")
        .then(response => {
          this.quote = response.data.sentence;
        })
        .catch(error => {
          console.error("Error fetching quote:", error);
        });
    },
    fetchTasks() {
      fetch("/api/test")
        .then((response) => response.json())
        .then((data) => {
          this.tasks = data.Task;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
    submitTask() {
  if (this.task.length === 0) return;
  fetch("/api/test", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      task: this.task,
      status: "1",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      this.tasks.push(data.task); 
      this.task = ""; 
      window.location.reload(); 
    })
    .catch((error) => {
      console.error("Error:", error);
    });
},


deleteTask(id) {
  fetch(`/api/test/edit/${id}`, { 
    method: "DELETE"
  })
    .then((response) => {
      if (response.ok) {
        this.tasks = this.tasks.filter(task => task.id !== id);
      } else {
        console.error("Failed to delete task");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
},

toggleTaskStatus(task) {
  // Toggle the status between 0 and 1
  task.status = task.status === '1' ? '0' : '1';

  fetch(`/api/test/edit/${task.id}`, { 
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      status: task.status,
    }),
  })
    .then((response) => {
      if (response.ok) {
        window.location.reload();
      } else {
        console.error("Failed to update task status");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
},


    confirmDelete(id) {
      if (confirm("Are you sure you want to delete this task?")) {
        this.deleteTask(id);
      }
    }
  }
};
</script>

<style scoped>

@font-face {
  font-family: 'GameOfThrones';
  src: url('/fonts/got.ttf') format('truetype');
}

.task-text {
  font-family: 'GameOfThrones', cursive;
}
.line-through {
  text-decoration: line-through;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.refresh-btn {
  background-color: transparent;
  color: white;
  border: none;
  cursor: pointer;
  transition: transform 0.3s ease-in-out;
}
.refresh-btn:hover {
  transform: rotate(360deg);
}
</style>
