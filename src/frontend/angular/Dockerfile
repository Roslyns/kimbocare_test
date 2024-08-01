# syntax=docker/dockerfile:1.4

FROM node:18-alpine AS development
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
ENV CI=true
RUN npm cache clean --force

FROM development AS build
RUN npm run build:docker

FROM nginx:1.25.3-alpine-slim
COPY --from=build /app/deploy/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
ENTRYPOINT ["nginx", "-g", "daemon off;"]