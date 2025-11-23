# Mobile App API Documentation

## Overview

This document describes all API endpoints used by the mobile app (Vue3) to communicate with the backend Laravel application. The mobile app uses a single unified endpoint `/apiw` with action-based routing.

**Base URL**: `https://panel.drhanasabzadeh.ir/apiw`

**Authentication**: Bearer token in Authorization header

**Method**: POST for all endpoints

**Content-Type**: application/json

## API Structure

All requests follow this pattern:

```json
POST /apiw
Authorization: Bearer {token}
Content-Type: application/json

{
  "action": "endpoint_name",
  "param1": "value1",
  "param2": "value2",
  ...
}
```

## API Endpoints (40+)

### 1. Authentication Endpoints

#### 1.1 Send SMS Verification Code
**Action**: `sendsms`

**Request**:
```json
{
  "action": "sendsms",
  "mobile": "09123456789"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Verification code sent"
}
```

#### 1.2 Sign In
**Action**: `signin`

**Request**:
```json
{
  "action": "signin",
  "mobile": "09123456789",
  "code": "12345"
}
```

**Response**:
```json
{
  "ok": 1,
  "token": "bearer_token_here",
  "user": {
    "id": 1,
    "name": "User Name",
    "mobile": "09123456789"
  }
}
```

#### 1.3 Get Login Page Picture/Captcha
**Action**: `loginPic`

**Request**:
```json
{
  "action": "loginPic"
}
```

**Response**:
```json
{
  "ok": 1,
  "image_url": "/images/login/banner.jpg"
}
```

---

### 2. User Profile Endpoints

#### 2.1 Get Profile
**Action**: `getProfile`

**Request**:
```json
{
  "action": "getProfile",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "data": {
    "name": "User Name",
    "email": "user@example.com",
    "mobile": "09123456789",
    "avatar": "/images/avatar/user.jpg",
    "wallet_balance": 50000
  }
}
```

#### 2.2 Edit Profile
**Action**: `editProfile`

**Request**:
```json
{
  "action": "editProfile",
  "name": "New Name",
  "email": "newemail@example.com",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Profile updated successfully"
}
```

#### 2.3 View Info
**Action**: `viewInfo`

**Request**:
```json
{
  "action": "viewInfo",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "data": {
    "user_info": {...},
    "statistics": {...}
  }
}
```

---

### 3. Home & Data Endpoints

#### 3.1 Home Data
**Action**: `homeData`

**Request**:
```json
{
  "action": "homeData",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "banners": [...],
  "featured_courses": [...],
  "live_sessions": [...],
  "statistics": {
    "total_courses": 150,
    "total_students": 5000,
    "total_teachers": 25
  }
}
```

#### 3.2 Languages
**Action**: `languages`

**Request**:
```json
{
  "action": "languages"
}
```

**Response**:
```json
{
  "ok": 1,
  "languages": [
    {"code": "fa", "name": "فارسی"},
    {"code": "en", "name": "English"}
  ]
}
```

---

### 4. Course Endpoints

#### 4.1 List Courses
**Action**: `courses`

**Request**:
```json
{
  "action": "courses",
  "filter": 1,
  "catref": 0,
  "pageref": 0,
  "ref": 0,
  "lang": "fa"
}
```

**Filter Values**:
- 1: All courses
- 2: Free courses
- 3: Shared courses
- 4: Buyable courses

**Response**:
```json
{
  "ok": 1,
  "data": [
    {
      "ID": 1,
      "Name": "Course Name",
      "Pic": "course1.jpg",
      "Teacher": "Teacher Name",
      "Price": "250,000 تومان",
      "PriceOff": "300,000 تومان",
      "PriceOffInt": 1,
      "MeetCount": 12,
      "Participants": 150,
      "Rating": 4.5
    }
  ],
  "data_cat": [
    {
      "ID": 1,
      "Name": "Category Name",
      "Pic": "cat1.jpg"
    }
  ]
}
```

#### 4.2 Course Meetings/Sessions
**Action**: `meets`

**Request**:
```json
{
  "action": "meets",
  "course_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "course": {
    "id": 1,
    "name": "Course Name",
    "description": "..."
  },
  "meets": [
    {
      "id": 1,
      "title": "Session 1",
      "duration": "45:30",
      "is_free": 0
    }
  ]
}
```

#### 4.3 Get Course Video Link
**Action**: `getLink`

**Request**:
```json
{
  "action": "getLink",
  "meet_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "link": "https://video-url.com/video.mp4",
  "has_access": 1
}
```

#### 4.4 Load More Comments
**Action**: `moreComment`

**Request**:
```json
{
  "action": "moreComment",
  "course_id": 1,
  "offset": 10,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "comments": [
    {
      "id": 1,
      "user": "User Name",
      "comment": "Great course!",
      "rating": 5,
      "date": "2025-01-01"
    }
  ]
}
```

---

### 5. Live Session Endpoints

#### 5.1 List Live Sessions
**Action**: `live`

**Request**:
```json
{
  "action": "live",
  "filter": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "data": [
    {
      "id": 1,
      "title": "Live Session Title",
      "scheduled_at": "2025-01-15 18:00",
      "status": "scheduled",
      "participants_count": 45
    }
  ]
}
```

#### 5.2 Live Session Details
**Action**: `liveDetail`

**Request**:
```json
{
  "action": "liveDetail",
  "live_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "live": {
    "id": 1,
    "title": "...",
    "description": "...",
    "scheduled_at": "...",
    "duration": 90,
    "teacher": "..."
  },
  "comments": [...]
}
```

#### 5.3 Get Live Play Link
**Action**: `livePlay`

**Request**:
```json
{
  "action": "livePlay",
  "live_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "stream_url": "https://stream-url.com/live",
  "has_access": 1
}
```

#### 5.4 Get Live Meeting Link
**Action**: `getLiveLink`

**Request**:
```json
{
  "action": "getLiveLink",
  "live_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "meeting_url": "https://meet.example.com/abc123"
}
```

#### 5.5 Send Live Session Comment
**Action**: `sendCommentLive`

**Request**:
```json
{
  "action": "sendCommentLive",
  "live_id": 1,
  "comment": "Great session!",
  "rating": 5,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Comment posted successfully"
}
```

---

### 6. Exam Endpoints

#### 6.1 List Exams
**Action**: `exams`

**Request**:
```json
{
  "action": "exams",
  "course_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "exams": [
    {
      "id": 1,
      "title": "Final Exam",
      "duration": 60,
      "questions_count": 20,
      "status": "published"
    }
  ]
}
```

#### 6.2 Exam Details
**Action**: `examDetail`

**Request**:
```json
{
  "action": "examDetail",
  "exam_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "exam": {
    "id": 1,
    "title": "...",
    "description": "...",
    "duration": 60,
    "total_marks": 100,
    "attempts_allowed": 3,
    "attempts_used": 1
  }
}
```

#### 6.3 Get Exam Questions
**Action**: `examQuestion`

**Request**:
```json
{
  "action": "examQuestion",
  "exam_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "questions": [
    {
      "id": 1,
      "question": "Question text?",
      "type": "multiple_choice",
      "options": [
        {"id": 1, "text": "Option A"},
        {"id": 2, "text": "Option B"},
        {"id": 3, "text": "Option C"},
        {"id": 4, "text": "Option D"}
      ],
      "marks": 5
    }
  ]
}
```

#### 6.4 Get Exam Answer Key
**Action**: `examAnswer`

**Request**:
```json
{
  "action": "examAnswer",
  "exam_id": 1,
  "attempt_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "answers": [
    {
      "question_id": 1,
      "correct_answer": 2,
      "user_answer": 2,
      "is_correct": 1,
      "explanation": "..."
    }
  ],
  "score": 85,
  "total": 100
}
```

#### 6.5 Submit Exam Answers
**Action**: `examSendAnswer`

**Request**:
```json
{
  "action": "examSendAnswer",
  "exam_id": 1,
  "answers": [
    {"question_id": 1, "answer": 2},
    {"question_id": 2, "answer": 1}
  ],
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "attempt_id": 1,
  "score": 85,
  "total": 100,
  "passed": 1,
  "message": "Exam submitted successfully"
}
```

---

### 7. Channel Endpoints

#### 7.1 List Channels
**Action**: `channels`

**Request**:
```json
{
  "action": "channels",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "channels": [
    {
      "id": 1,
      "name": "Channel Name",
      "description": "...",
      "posts_count": 25,
      "image": "channel1.jpg"
    }
  ]
}
```

#### 7.2 Get Channel Posts
**Action**: `channelsPost`

**Request**:
```json
{
  "action": "channelsPost",
  "channel_id": 1,
  "offset": 0,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "posts": [
    {
      "id": 1,
      "title": "Post Title",
      "content": "...",
      "image": "post1.jpg",
      "created_at": "2025-01-01",
      "views": 150,
      "comments_count": 10
    }
  ]
}
```

#### 7.3 Send Comment
**Action**: `sendComment`

**Request**:
```json
{
  "action": "sendComment",
  "post_id": 1,
  "comment": "Great post!",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Comment posted successfully"
}
```

---

### 8. Challenge Endpoints

#### 8.1 List Challenges
**Action**: `challenge`

**Request**:
```json
{
  "action": "challenge",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "challenges": [
    {
      "id": 1,
      "title": "Challenge Title",
      "description": "...",
      "reward": "100,000 تومان",
      "participants": 50,
      "deadline": "2025-02-01"
    }
  ]
}
```

#### 8.2 Challenge Details
**Action**: `challengeDetail`

**Request**:
```json
{
  "action": "challengeDetail",
  "challenge_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "challenge": {
    "id": 1,
    "title": "...",
    "description": "...",
    "rules": "...",
    "reward": "...",
    "deadline": "...",
    "participants": 50
  },
  "submissions": [...]
}
```

#### 8.3 Send Challenge Comment
**Action**: `sendCommentChallenge`

**Request**:
```json
{
  "action": "sendCommentChallenge",
  "challenge_id": 1,
  "comment": "Interesting challenge!",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Comment posted successfully"
}
```

---

### 9. Subscription & Payment Endpoints

#### 9.1 List Subscriptions
**Action**: `subscriptions`

**Request**:
```json
{
  "action": "subscriptions",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "subscriptions": [
    {
      "id": 1,
      "name": "Basic Plan",
      "price": "500,000 تومان",
      "duration": "3 months",
      "features": ["Feature 1", "Feature 2"]
    }
  ]
}
```

#### 9.2 Get Payment Info
**Action**: `getPayInfo`

**Request**:
```json
{
  "action": "getPayInfo",
  "item_type": "course",
  "item_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "item": {
    "name": "Course Name",
    "price": 250000,
    "discount": 50000,
    "final_price": 200000
  }
}
```

#### 9.3 Get Payment Link
**Action**: `getPayLink`

**Request**:
```json
{
  "action": "getPayLink",
  "item_type": "course",
  "item_id": 1,
  "discount_code": "DISCOUNT10",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "payment_url": "https://payment-gateway.com/pay/abc123",
  "order_id": 123
}
```

#### 9.4 Payment Result
**Action**: `payresult`

**Request**:
```json
{
  "action": "payresult",
  "order_id": 123,
  "status": "success",
  "transaction_id": "TXN123456",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "status": "success",
  "message": "Payment successful",
  "order": {...}
}
```

#### 9.5 Validate Discount Code
**Action**: `discount`

**Request**:
```json
{
  "action": "discount",
  "code": "DISCOUNT10",
  "item_type": "course",
  "item_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "valid": 1,
  "discount_amount": 50000,
  "discount_percent": 20,
  "message": "Discount applied successfully"
}
```

---

### 10. Wallet Endpoints

#### 10.1 Wallet History
**Action**: `walletHistory`

**Request**:
```json
{
  "action": "walletHistory",
  "offset": 0,
  "limit": 20,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "balance": 500000,
  "transactions": [
    {
      "id": 1,
      "type": "deposit",
      "amount": 100000,
      "description": "...",
      "date": "2025-01-01"
    }
  ]
}
```

#### 10.2 Get Currency Price
**Action**: `getCurrencyPrice`

**Request**:
```json
{
  "action": "getCurrencyPrice",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "currencies": [
    {"code": "USD", "rate": 50000, "name": "دلار آمریکا"},
    {"code": "EUR", "rate": 55000, "name": "یورو"}
  ]
}
```

---

### 11. Support Endpoints

#### 11.1 List Support Tickets
**Action**: `support`

**Request**:
```json
{
  "action": "support",
  "status": "open",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "tickets": [
    {
      "id": 1,
      "subject": "Ticket Subject",
      "status": "open",
      "priority": "normal",
      "created_at": "2025-01-01",
      "last_reply": "2025-01-02"
    }
  ]
}
```

#### 11.2 Support Ticket Details
**Action**: `supportDetail`

**Request**:
```json
{
  "action": "supportDetail",
  "ticket_id": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "ticket": {
    "id": 1,
    "subject": "...",
    "status": "...",
    "priority": "..."
  },
  "messages": [
    {
      "id": 1,
      "sender": "user",
      "message": "...",
      "created_at": "..."
    }
  ]
}
```

#### 11.3 Create Support Ticket
**Action**: `sendSupport`

**Request**:
```json
{
  "action": "sendSupport",
  "subject": "Issue with course",
  "message": "Detailed description...",
  "priority": "normal",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "ticket_id": 1,
  "message": "Ticket created successfully"
}
```

#### 11.4 Reply to Support Ticket
**Action**: `sendSupportResponse`

**Request**:
```json
{
  "action": "sendSupportResponse",
  "ticket_id": 1,
  "message": "My reply...",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Reply sent successfully"
}
```

---

### 12. Counseling Endpoints

#### 12.1 Book Counseling
**Action**: `counseling`

**Request**:
```json
{
  "action": "counseling",
  "date": "2025-01-15",
  "time": "18:00",
  "topic": "Career advice",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "appointment_id": 1,
  "message": "Appointment booked successfully"
}
```

---

### 13. Content Endpoints

#### 13.1 Get Terms & Conditions
**Action**: `getTerms`

**Request**:
```json
{
  "action": "getTerms",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "terms": "Terms and conditions content..."
}
```

#### 13.2 Get Contact Information
**Action**: `getContact`

**Request**:
```json
{
  "action": "getContact",
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "contact": {
    "phone": "021-12345678",
    "email": "info@example.com",
    "address": "...",
    "social_media": {...}
  }
}
```

#### 13.3 Set Favorite
**Action**: `setFav`

**Request**:
```json
{
  "action": "setFav",
  "item_type": "course",
  "item_id": 1,
  "is_favorite": 1,
  "lang": "fa"
}
```

**Response**:
```json
{
  "ok": 1,
  "message": "Added to favorites"
}
```

---

## Implementation Priority

### Phase 1: Critical (Week 1)
1. **Authentication**: sendsms, signin, loginPic
2. **Home Data**: homeData
3. **User Profile**: getProfile, editProfile
4. **Courses**: courses, meets

### Phase 2: Important (Week 2)
5. **Live Sessions**: live, liveDetail, livePlay
6. **Exams**: exams, examDetail, examQuestion
7. **Payments**: getPayInfo, getPayLink, payresult
8. **Wallet**: walletHistory

### Phase 3: Moderate (Week 3)
9. **Channels**: channels, channelsPost
10. **Support**: support, supportDetail, sendSupport
11. **Comments**: sendComment, moreComment
12. **Subscriptions**: subscriptions

### Phase 4: Low Priority (Week 4)
13. **Challenges**: challenge, challengeDetail
14. **Counseling**: counseling
15. **Content**: getTerms, getContact
16. **Misc**: languages, getCurrencyPrice, setFav

---

## Authentication

All API endpoints (except authentication endpoints) require a Bearer token:

```
Authorization: Bearer {token}
```

Token is stored in localStorage on mobile app after successful login:
```javascript
localStorage.getItem('tk')
```

---

## Error Handling

**Error Response Format**:
```json
{
  "ok": 0,
  "error": "Error message",
  "error_code": "ERROR_CODE"
}
```

**Common Error Codes**:
- `UNAUTHORIZED`: Invalid or missing token
- `VALIDATION_ERROR`: Invalid request parameters
- `NOT_FOUND`: Resource not found
- `PERMISSION_DENIED`: User doesn't have access
- `SERVER_ERROR`: Internal server error

---

## Notes

- All dates in Persian calendar format where applicable
- All prices in Iranian Rials (تومان)
- Language parameter (lang): "fa" or "en"
- Pagination: Use offset and limit parameters
- All responses include "ok" field (1 = success, 0 = error)

---

## Total Endpoints: 40+

Categorized by functionality:
- Authentication: 3
- User Profile: 3
- Home & Data: 2
- Courses: 4
- Live Sessions: 5
- Exams: 5
- Channels: 3
- Challenges: 3
- Subscriptions & Payments: 5
- Wallet: 2
- Support: 4
- Counseling: 1
- Content: 3

**Total**: 43 unique API endpoints
