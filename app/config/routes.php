<?php
return [
  // MAIN
  [
    "controller"=>"MainController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/",
        "action"=>"index",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/doc",
        "action"=>"doc",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/swagger.json",
        "action"=>"swagger",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/sha512/{t}",
        "action"=>"sha512",
        "checkAuth"=>false,
      ],
    ],
  ],
  // Belajar
  [
    "controller"=>"BelajarController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/belajar",
        "action"=>"getData",
        "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/belajar/add",
        "action"=>"addData",
        "checkAuth"=>false,
      ],
    ],
  ],
  // AUTH
  [
    "controller"=>"AuthController",
    "data"=>[
      [
        "method"=>"post",
        "path"=>"/auth/get_token",
        "action"=>"get_token",
        "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/auth/logout",
        "action"=>"logout",
      ],
      [
        "method"=>"post",
        "path"=>"/initialize",
        "action"=>"initialize",
      ],
      [
        "method"=>"get",
        "path"=>"/auth/has_token",
        "action"=>"has_token",
         "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/auth/check_token",
        "action"=>"check_token",
         "checkAuth"=>false,
      ],
    ],
  ],
  // USER
  [
    "controller"=>"UserController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/user/profile",
        "action"=>"getProfile",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/user/register",
        "action"=>"register",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/user/profile",
        "action"=>"getProfile",
      ],
      [
        "method"=>"get",
        "path"=>"/user/notification",
        "action"=>"getNotification",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/user/photo",
        "action"=>"updateUserPhoto",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/user/photo",
        "action"=>"getUserPhoto",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/user/notification_presence_student",
        "action"=>"getNotifPresenceStudent",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/user/notification_presence_teacher",
        "action"=>"getNotifPresenceTeacher",
        // "checkAuth"=>false,
      ]
    ],
  ],
  // TEACHER
  [
    "controller"=>"TeacherController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/schools/teacher_contacts",
        "action"=>"getContacts",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/schools/add_student",
        "action"=>"addStudents",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/teacher/presence",
        "action"=>"postTeacherPresence",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/teacher/presence",
        "action"=>"getTeacherPresence",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/teacher/register",
        "action"=>"teacherRegister",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/teacher/get_teachers",
        "action"=>"getTeachers",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/teacher/presence_history",
        "action"=>"getTeacherPresenceHistory",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/teacher/photo",
        "action"=>"getTeacherPhoto",
        // "checkAuth"=>false,
      ],
    ],
  ],
  // STUDENT
  [
    "controller"=>"StudentsController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/school/student",
        "action"=>"getStudents",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/school/student/export",
        "action"=>"export",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/school/student/profile",
        "action"=>"getProfile",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/school/student/presence",
        "action"=>"getStudentPresence",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/school/student/presence",
        "action"=>"postStudentPresence",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/learning/question",
        "action"=>"getLearningQuestions",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/learning/answer",
        "action"=>"postLearningAnswers",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/learning/style",
        "action"=>"getLearningStyle",
        // "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/student/photo",
        "action"=>"getStudentPhoto",
        // "checkAuth"=>false
      ],
    ],
  ],
  // EVENT
  [
    "controller"=>"EventController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/school/event",
        "action"=>"getEvents",
        //// "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/school/event",
        "action"=>"postEvent",
        //// "checkAuth"=>false,
      ],
      // [
      //   "method"=>"put",
      //   "path"=>"/school/event",
      //   "action"=>"putEvent",
      //   //// "checkAuth"=>false,
      // ],
    ],
  ],
  // UTILS
  [
    "controller"=>"UtilsController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/utils/question",
        "action"=>"getQuestion",
        //// "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/intellegence",
        "action"=>"getIntellegence",
        //// "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/activities",
        "action"=>"getActivities",
        //// "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/cluster",
        "action"=>"getCluster",
        //// "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/classref",
        "action"=>"getClassRef",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/roles",
        "action"=>"getRoles",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/grades",
        "action"=>"getGrades",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/utils/parentref",
        "action"=>"getParentRef",
        // "checkAuth"=>false
      ],
    ],
  ],
  // ANNOUNCEMENT
  [
    "controller"=>"AnnouncementController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/school/announcement",
        "action"=>"getAnnouncements",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/school/announcement",
        "action"=>"postAnnouncement",
        // "checkAuth"=>false
      ],
      [
        "method"=>"put",
        "path"=>"/school/announcement",
        "action"=>"putAnnouncement",
        // "checkAuth"=>false
      ],
      [
        "method"=>"delete",
        "path"=>"/school/announcement",
        "action"=>"delete",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/school/announcement/photo",
        "action"=>"updateAnnouncementPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/school/announcement/photo",
        "action"=>"getAnnouncementPhoto",
        // "checkAuth"=>false
      ],
    ],
  ],
  // ACTIVITIY
  [
    "controller"=>"ActivityController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/student/activity",
        "action"=>"getActivities",
        //// "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity",
        "action"=>"postActivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"put",
        "path"=>"/student/activity",
        "action"=>"putActivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"put",
        "path"=>"/student/activity/verify",
        "action"=>"verifyActivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/export",
        "action"=>"exportTalentMapping",
        // "checkAuth"=>false
      ],
      [
        "method" => "get",
        "path" => "/student/intellegence/export",
        "action" => "exportMultiIntellegence",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity/photo",
        "action"=>"updateActivityPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity/video",
        "action"=>"updateActivityVideo",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/photo",
        "action"=>"getActivityPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/video",
        "action"=>"getActivityVideo",
        "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/video/thumbnail",
        "action"=>"getActivityVideoThumbnail",
        // "checkAuth"=>false
      ],
    ],
  ],
  // ACTIVITY COMMENT
  [
    "controller"=>"ActivityCommentController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/student/activity/comment",
        "action"=>"getComment",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity/comment",
        "action"=>"postComment",
        // "checkAuth"=>false
      ],
    ],
  ],
  // EXPERT
  [
    "controller" => "ExpertController",
    "data" => [
      [
        "method" => "get",
        "path" => "/expert",
        "action" => "getExpert",
        // "checkAuth"=>false
      ],
    ],
  ],
  // GENERAL ACTIVITY COMMENT
  [
    "controller"=>"GeneralactivityCommentController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/student/generalactivity/comment",
        "action"=>"getGeneralactivityComment",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/generalactivity/comment",
        "action"=>"postGeneralactivityComment",
        // "checkAuth"=>false
      ],
    ],
  ],
  //SCHOOL
  [
    "controller" => "SchoolController",
    "data" => [
      [
        "method" => "get",
        "path" => "/school",
        "action" => "getSchools",
        "checkAuth"=>false
      ],
     [
        "method" => "post",
        "path" => "/school/register",
        "action"=>"postSchool",
        // "checkAuth"=>false,
      ],
    ],
  ],
  //PARENT
  [
    "controller" => "ParentController",
    "data" => [
      [
        "method" => "get",
        "path" => "/parent",
        "action" => "getParent",
        // "checkAuth"=>false
      ],
      [
        "method" => "post",
        "path" => "/parent",
        "action"=>"parentRegister",
        "checkAuth"=>false,
      ],
    ],
  ],
  //CLUSTER
  [
    "controller" => "ClusterController",
    "data" => [
      [
        "method" => "get",
        "path" => "/cluster/peran",
        "action" => "getPeran",
        // "checkAuth"=>false
      ],
    ],
  ],
  // GENERAL ACTIVITIY
  [
    "controller"=>"GeneralactivityController",
    "data"=>[
      [
        "method"=>"post",
        "path"=>"/student/generalactivity",
        "action"=>"postGeneralactivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/generalactivity",
        "action"=>"getGeneralactivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/description",
        "action"=>"getDescription",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/generalactivity/photo",
        "action"=>"updateGeneralactivityphoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/generalactivity/video",
        "action"=>"updateGeneralactivityvideo",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/generalactivity/photo",
        "action"=>"getGeneralactivityPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/generalactivity/video",
        "action"=>"getGeneralactivityVideo",
        "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/generalactivity/video/thumbnail",
        "action"=>"getGeneralactivityVideoThumbnail",
        "checkAuth"=>false
      ],

      [
        "method"=>"put",
        "path"=>"/student/activity",
        "action"=>"putActivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"put",
        "path"=>"/student/activity/verify",
        "action"=>"verifyActivity",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/export",
        "action"=>"exportTalentMapping",
        // "checkAuth"=>false
      ],
      [
        "method" => "get",
        "path" => "/student/intellegence/export",
        "action" => "exportMultiIntellegence",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity/photo",
        "action"=>"updateActivityPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"post",
        "path"=>"/student/activity/video",
        "action"=>"updateActivityVideo",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/photo",
        "action"=>"getActivityPhoto",
        // "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/video",
        "action"=>"getActivityVideo",
        "checkAuth"=>false
      ],
      [
        "method"=>"get",
        "path"=>"/student/activity/video/thumbnail",
        "action"=>"getActivityVideoThumbnail",
        // "checkAuth"=>false
      ],
    ],
  ],
];