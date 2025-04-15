up:
	docker compose up -d
down:
	docker compose down
restart:
	@make down
	@make up
logs:
	docker compose logs -f
ps:
	docker compose ps
certs:
	@docker exec $$(docker ps -qf "name=acme-companion") ls /etc/nginx/certs || echo "acme-companion が起動していないか、証明書未作成"