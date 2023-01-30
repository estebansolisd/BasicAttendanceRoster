<template>
  <div class="container">
    <h1>Basic Attendance Roster</h1>
    <div class="table-container">
      <table v-if="students.length">
        <thead>
          <tr>
            <td v-for="value in Object.keys(students[0])" :key="value">
              {{
                value
                  .split("_")
                  .map((word) => word[0].toUpperCase() + word.slice(1))
                  .join(" ")
              }}
            </td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.student_id">
            <td>
              {{ student.student_id }}
            </td>
            <td>
              {{ student.first_name }}
            </td>
            <td>
              {{ student.last_name }}
            </td>
            <td>
              {{ student.email }}
            </td>
            <td>
              <input
                type="checkbox"
                :checked="!!student.attendance"
                @change="e => handleChange(student.student_id, e.target.checked)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import fetchData from "../api";
export default {
  name: "Dashboard",
  data() {
    return {
      students: [],
    };
  },
  mounted() {
    this.loadStudents();
  },
  methods: {
    async loadStudents() {
      try {
        const students = await fetchData({ path: "/students" });
        this.students = students.map(
          ({ created_at, updated_at, ...student }) => student
        );
      } catch (err) {
        console.error(err, "Error loading students");
      }
    },
    async updateStudent(student_id, checked) {
      try {
        const result = await fetchData({
          path: `/students/${student_id}`,
          data: { attendance: checked ? 1 : 0 },
          method: "PATCH"
        });
        alert(result ? "Attendance updated" : "Attendance not updated")
      } catch (err) {
        console.error(err, `error while updating attendance from student ${student_id}`);
      }
    },
    handleChange(student_id, checked) {
      this.students = this.students.map((student) =>
        student_id === student.student_id
          ? { ...student, attendance: checked ? 1 : 0 }
          : student
      );
      this.updateStudent(student_id, checked);
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
table thead tr {
  background-color: #127b95;
  color: #ffffff;
  text-align: left;
}
table th,
table td {
  padding: 12px 15px;
}
table tbody tr {
  border-bottom: 1px solid #dddddd;
}

table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

table tbody tr:last-of-type {
  border-bottom: 2px solid #009879;
}
.table-container {
  height: 500px;
  overflow: auto;
}
</style>
